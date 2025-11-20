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
        $request->validate([
            'id' => 'required|integer|min:1'
        ]);

        $menu = Menu::find($request->id);
        if (!$menu) {
            return response()->json(['error' => 'Menu tidak ditemukan'], 404);
        }

        // 2. Ambil keranjang dari session
        $cart = session()->get('cart', []);

        // 3. Cek jika item sudah ada, tambahkan kuantitasnya
        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['quantity']++;
        } else {
            // Jika item baru, tambahkan ke keranjang
            $cart[$menu->id] = [
                "name" => $menu->name,
                "quantity" => 1,
                "price" => $menu->price,
                "image" => $menu->image_path
            ];
        }

        // 4. Simpan kembali keranjang ke session
        session()->put('cart', $cart);

        // 5. Hitung total baru
        list($totalPrice, $itemCount) = $this->calculateCartTotals($cart);

        // 6. Kembalikan response JSON untuk AJAX
        return response()->json([
            'message' => 'Menu berhasil ditambahkan!',
            'itemCount' => $itemCount,
            'totalPrice' => number_format($totalPrice, 0, ',', '.')
        ]);
    }

    /**
     * Mengupdate kuantitas item di keranjang via AJAX (Langkah 2.5)
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1|max:999'
        ]);

        $cart = session()->get('cart', []);
        if (isset($cart[$request->id])) {
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);

            list($totalPrice, $itemCount) = $this->calculateCartTotals($cart);

            return response()->json([
                'message' => 'Keranjang berhasil diperbarui!',
                'itemCount' => $itemCount,
                'totalPrice' => number_format($totalPrice, 0, ',', '.'),
            ]);
        }

        return response()->json(['error' => 'Item tidak ditemukan di keranjang'], 404);
    }

    /**
     * Menghapus item dari keranjang via AJAX (Langkah 2.5)
     */
    public function remove(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);

            list($totalPrice, $itemCount) = $this->calculateCartTotals($cart);

            return response()->json([
                'message' => 'Item berhasil dihapus!',
                'itemCount' => $itemCount,
                'totalPrice' => number_format($totalPrice, 0, ',', '.'),
            ]);
        }

        return response()->json(['error' => 'Item tidak ditemukan'], 404);
    }
}