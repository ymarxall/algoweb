<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu; // <-- Pastikan Model Menu di-import

class CartController extends Controller
{
    /**
     * Fungsi helper pribadi untuk menghitung total keranjang.
     * Ini akan kita gunakan di semua fungsi lain.
     */
    private function calculateCartTotals($cart)
    {
        $totalPrice = 0;
        $itemCount = 0;
        if (is_array($cart)) {
            foreach ($cart as $id => $details) {
                $totalPrice += $details['price'] * $details['quantity'];
                $itemCount += $details['quantity'];
            }
        }
        return [$totalPrice, $itemCount];
    }

    /**
     * Menampilkan halaman keranjang belanja (Langkah 2.5)
     */
    public function index()
    {
        $cart = session()->get('cart', []); // Perbaikan: tambah default array kosong, hapus koma ekstra
        list($totalPrice, $itemCount) = $this->calculateCartTotals($cart);

        // Kirim data ke view 'customer.cart'
        // Kita akan buat view ini di langkah berikutnya
        return view('customer.cart', compact('cart', 'totalPrice', 'itemCount'));
    }

    /**
     * Menambahkan item ke keranjang via AJAX (Langkah 2.4)
     */
    public function add(Request $request)
    {
        // 1. Validasi request
        $menu = Menu::find($request->id);
        if (!$menu) {
            return response()->json(['error' => 'Menu not found'], 404);
        }

        // 2. Ambil keranjang dari session
        $cart = session()->get('cart', []); // Perbaikan: default array kosong

        // 3. Cek jika item sudah ada, tambahkan kuantitasnya
        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['quantity']++; // Hapus anotasi [1]
        } else {
            // Jika item baru, tambahkan ke keranjang
            $cart[$menu->id] = [
                "name" => $menu->name,
                "quantity" => 1,
                "price" => $menu->price,
                "image" => $menu->image_path // (Asumsi Anda punya kolom 'image_path' di migrasi 'menus')
            ];
        }

        // 4. Simpan kembali keranjang ke session
        session()->put('cart', $cart); // Hapus anotasi [1, 9]

        // 5. Hitung total baru
        list($totalPrice, $itemCount) = $this->calculateCartTotals($cart);

        // 6. Kembalikan response JSON untuk AJAX
        // --- PERBAIKAN DI BAWAH INI ---
        // Kita harus mengembalikan data JSON agar JavaScript bisa memperbarui halaman.
        return response()->json([
            'message' => 'Menu berhasil ditambahkan!',
            'itemCount' => $itemCount,
            'totalPrice' => number_format($totalPrice, 0, ',', '.')
        ]);
        // --- AKHIR PERBAIKAN ---
    }

    /**
     * Mengupdate kuantitas item di keranjang via AJAX (Langkah 2.5)
     */
    public function update(Request $request)
    {
        if ($request->id && $request->quantity && $request->quantity > 0) { // Tambah validasi quantity > 0
            $cart = session()->get('cart', []); // Default array
            if (isset($cart[$request->id])) {
                $cart[$request->id]["quantity"] = $request->quantity;
                session()->put('cart', $cart); // Hapus anotasi [9, 12, 13]
            }

            list($totalPrice, $itemCount) = $this->calculateCartTotals($cart);

            return response()->json([
                'message' => 'Keranjang berhasil diperbarui!',
                'itemCount' => $itemCount,
                'totalPrice' => number_format($totalPrice, 0, ',', '.'),
            ]);
        }

        return response()->json(['error' => 'Invalid request'], 400); // Tambah error handling
    }

    /**
     * Menghapus item dari keranjang via AJAX (Langkah 2.5)
     */
    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart', []); // Default array
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]); // Hapus item
                session()->put('cart', $cart); // Hapus anotasi [1, 9]
            }

            list($totalPrice, $itemCount) = $this->calculateCartTotals($cart);

            return response()->json([
                'message' => 'Item berhasil dihapus!',
                'itemCount' => $itemCount,
                'totalPrice' => number_format($totalPrice, 0, ',', '.'),
            ]);
        }

        return response()->json(['error' => 'Invalid request'], 400); // Tambah error handling
    }
}