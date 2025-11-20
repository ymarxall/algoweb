<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\Table;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi request
        $validated = $request->validate([
            'customer_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-\.]+$/'
            ],
            'payment_method' => 'required|in:ovo,gopay,dana,shopeepay,linkaja,cash',
        ], [
            'customer_name.regex' => 'Nama hanya boleh mengandung huruf, angka, spasi, dash, dan titik.'
        ]);

        // 2. Ambil data dari session
        $tableId = Session::get('table_id');
        $cart = Session::get('cart', []);

        // 3. Validasi table exists
        if (!$tableId || !Table::where('id', $tableId)->exists()) {
            Log::warning('Invalid checkout attempt - table not found', ['table_id' => $tableId]);
            return response()->json([
                'error' => 'Meja tidak valid. Silakan reload halaman.',
                'redirect' => '/meja/1'
            ], 400);
        }

        // 4. Validasi cart tidak kosong
        if (empty($cart)) {
            Log::warning('Empty cart checkout attempt', ['table_id' => $tableId]);
            return response()->json([
                'error' => 'Keranjang kosong.'
            ], 400);
        }

        // 5. Hitung total dari cart
        $totalPrice = 0;
        foreach ($cart as $details) {
            $totalPrice += $details['price'] * $details['quantity'];
        }

        // 6. Validasi total price
        if ($totalPrice <= 0) {
            Log::warning('Invalid total price', ['total' => $totalPrice, 'table_id' => $tableId]);
            return response()->json([
                'error' => 'Total harga tidak valid.'
            ], 400);
        }

        try {
            // 7. Buat order dalam transaction (aman jika ada error)
            $order = DB::transaction(function () use ($tableId, $validated, $cart, $totalPrice) {
                // Buat order baru
                $order = Order::create([
                    'table_id' => $tableId,
                    'customer_name' => $validated['customer_name'],
                    'payment_method' => $validated['payment_method'],
                    'total_price' => $totalPrice,
                    'status' => 'pending',
                    'estimated_minutes' => 15,
                ]);

                // Simpan order details (relasi many-to-many via pivot)
                foreach ($cart as $menuId => $details) {
                    $menu = Menu::find($menuId);
                    if (!$menu) {
                        throw new \Exception("Menu ID {$menuId} tidak ditemukan.");
                    }

                    if ($details['quantity'] <= 0) {
                        throw new \Exception("Kuantitas menu {$menu->name} tidak valid.");
                    }

                    // Gunakan harga dari database, bukan dari cart (prevent price manipulation)
                    $order->menus()->attach($menuId, [
                        'quantity' => $details['quantity'],
                        'price' => $menu->price,
                    ]);
                }

                return $order;
            });

            // 8. Kosongkan cart setelah sukses
            Session::forget('cart');

            // 9. Log order creation
            Log::channel('orders')->info('Order created successfully', [
                'order_id' => $order->id,
                'customer_name' => $order->customer_name,
                'table_id' => $order->table_id,
                'total_price' => $order->total_price,
                'payment_method' => $order->payment_method,
            ]);

            // 10. Return JSON response untuk AJAX
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat!',
                'order_id' => $order->id,
                'redirect_url' => route('customer.waiting', ['orderId' => $order->id])
            ]);

        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Database error during checkout', [
                'error' => $e->getMessage(),
                'table_id' => $tableId
            ]);
            return response()->json([
                'error' => 'Terjadi kesalahan pada database. Silakan coba lagi.'
            ], 500);

        } catch (\Exception $e) {
            Log::error('Checkout error', [
                'error' => $e->getMessage(),
                'table_id' => $tableId
            ]);
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}