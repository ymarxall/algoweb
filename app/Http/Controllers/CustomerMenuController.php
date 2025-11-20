<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Table;
use App\Models\Menu;

class CustomerMenuController extends Controller
{
    /**
     * Tampilkan halaman menu untuk customer
     * Route: /meja/{no}
     */
    public function showMenu($no = 1)
    {
        // Cari atau buat table berdasarkan nomor
        $table = Table::where('table_number', $no)->first();
        
        if (!$table) {
            // Jika meja tidak ada, redirect ke meja 1
            return redirect()->route('customer.menu', ['no' => 1]);
        }

        // Simpan table_id ke session untuk checkout nanti
        session(['table_id' => $table->id, 'table_number' => $no]);

        // Ambil semua menu dengan kategori (eager loading)
        $categories = Category::with('menus')->get();
        $menus = Menu::with('category')->get();

        return view('customer.menu', compact('table', 'categories', 'menus', 'no'));
    }

    /**
     * API untuk fetch menu data (digunakan oleh AJAX di frontend)
     * Route: /api/menus
     */
    public function getMenus()
    {
        $menus = Menu::with('category')->get();
        
        // Transform data ke format yang dibutuhkan frontend
        $data = $menus->map(function ($menu) {
            return [
                'id' => $menu->id,
                'name' => $menu->name,
                'category' => strtolower($menu->category->name), // minuman, makanan, dll
                'price' => (int) $menu->price,
                'image' => $menu->image_path,
                'desc' => $menu->description,
            ];
        });

        return response()->json($data);
    }

    /**
     * Tampilkan halaman waiting untuk customer
     * Route: /waiting/{orderId}
     */
    public function waiting($orderId)
    {
        $order = \App\Models\Order::with('menus', 'table', 'statuses')->find($orderId);
        
        if (!$order) {
            return redirect()->route('customer.menu')->with('error', 'Pesanan tidak ditemukan');
        }

        return view('customer.waiting', compact('order'));
    }
}