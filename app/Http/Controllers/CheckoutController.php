<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Proses checkout dan simpan order (dari cart, via relasi pivot order_details).
     */
    public function store(Request $request)
    {
        // 1. Validasi request (tambah jika perlu field lain dari form)
        $request->validate([
            // 'table_id' => 'required|exists:tables,id', // Opsional, karena dari session
        ]);

        // 2. Ambil data dari session: table_id dan cart
        $tableId = Session::get('table_id');
        $cart = Session::get('cart', []);

        if (!$tableId || empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong atau meja tidak valid.');
        }

        // 3. Hitung total dari cart
        $totalPrice = 0;
        foreach ($cart as $details) {
            $totalPrice += $details['price'] * $details['quantity'];
        }

        // 4. Buat order dulu (match migration: no 'items', pakai payment_status & kitchen_status)
        $order = Order::create([
            'table_id' => $tableId,
            'total_price' => $totalPrice,
            'payment_status' => 'pending', // Sesuai enum di migration
            'kitchen_status' => 'pending', // Sesuai enum di migration
            // user_id null untuk guest (QR code meja)
            // snap_token null dulu, set nanti saat Midtrans
        ]);

        // 5. Attach menus ke order via pivot (loop cart, simpan quantity & price)
        foreach ($cart as $menuId => $details) {
            // Verifikasi menu masih ada (opsional, untuk keamanan)
            $menu = Menu::find($menuId);
            if ($menu && $details['quantity'] > 0) {
                $order->menus()->attach($menuId, [
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                    // 'subtotal' => $details['price'] * $details['quantity'], // Jika kolom subtotal ada di pivot
                ]);
            }
        }

        // 6. Kosongkan cart dan session setelah sukses
        Session::forget('cart');
        Session::forget('table_id');

        // 7. Redirect ke halaman sukses (pastikan route 'order.success' ada di web.php)
        return redirect()->route('order.success', $order->id)
                         ->with('success', 'Pesanan berhasil dibuat! No. Order: #' . $order->id . '. Total: Rp ' . number_format($totalPrice, 0, ',', '.'));
    }
}