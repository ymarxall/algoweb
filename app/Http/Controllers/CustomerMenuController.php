<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Table;
use App\Models\Menu; // Asumsi model Menu ada

class CustomerMenuController extends Controller
{
    public function showMenuForTable($id)
    {
        $table = Table::find($id);
        if (!$table) {
            abort(404, 'Meja tidak ditemukan.');
        }

        session(['table_id' => $table->id]);

        // Ambil kategori dengan menus (eager loading)
        $categories = Category::with('menus')->get();

        // Atau jika mau hardcode seperti Next.js (untuk test cepat)
        $menuItems = Menu::all(); // Atau array statis jika belum seed

        return view('customer.menu', compact('categories', 'table', 'menuItems'));
    }
}