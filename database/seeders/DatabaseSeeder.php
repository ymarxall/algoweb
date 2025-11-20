<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call other seeders
        $this->call([
            KasirSeeder::class,
        ]);

        // Buat user kasir (opsional - redundant dengan KasirSeeder)
        // Uncomment jika ingin tambahan user
        /*
        \App\Models\User::create([
            'name' => 'Customer Test',
            'email' => 'customer@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
            'status' => 'active',
        ]);
        */

        // Seed Categories
        $categories = [
            ['name' => 'Minuman', 'description' => 'Berbagai minuman segar'],
            ['name' => 'Makanan', 'description' => 'Menu makanan lezat'],
            ['name' => 'Dessert', 'description' => 'Pencuci mulut manis'],
            ['name' => 'Snack', 'description' => 'Camilan ringan'],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::create($cat);
        }

        // Seed Menus
        $menus = [
            ['category_id' => 1, 'name' => 'Espresso', 'description' => 'Kopi espresso pekat dan kaya rasa', 'price' => 25000, 'image_path' => 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?w=400'],
            ['category_id' => 1, 'name' => 'Cappuccino', 'description' => 'Espresso dengan foam susu lembut', 'price' => 35000, 'image_path' => 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=400'],
            ['category_id' => 1, 'name' => 'Latte', 'description' => 'Kopi susu dengan latte art cantik', 'price' => 38000, 'image_path' => 'https://images.unsplash.com/photo-1561882468-9110e03e0f78?w=400'],
            ['category_id' => 1, 'name' => 'Americano', 'description' => 'Espresso dengan air panas', 'price' => 28000, 'image_path' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=400'],
            ['category_id' => 2, 'name' => 'Nasi Goreng', 'description' => 'Nasi goreng spesial dengan telur', 'price' => 45000, 'image_path' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=400'],
            ['category_id' => 2, 'name' => 'Burger', 'description' => 'Burger beef dengan keju leleh', 'price' => 55000, 'image_path' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400'],
            ['category_id' => 2, 'name' => 'Pasta Carbonara', 'description' => 'Pasta creamy dengan bacon', 'price' => 58000, 'image_path' => 'https://images.unsplash.com/photo-1612874742237-6526221588e3?w=400'],
            ['category_id' => 2, 'name' => 'Sandwich', 'description' => 'Sandwich isi ayam dan sayuran', 'price' => 42000, 'image_path' => 'https://images.unsplash.com/photo-1528735602780-2552fd46c7af?w=400'],
            ['category_id' => 3, 'name' => 'Cheesecake', 'description' => 'Cheesecake lembut dengan topping', 'price' => 38000, 'image_path' => 'https://images.unsplash.com/photo-1524351199678-941a58a3df50?w=400'],
            ['category_id' => 3, 'name' => 'Tiramisu', 'description' => 'Tiramisu klasik Italia', 'price' => 42000, 'image_path' => 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?w=400'],
            ['category_id' => 4, 'name' => 'French Fries', 'description' => 'Kentang goreng renyah', 'price' => 25000, 'image_path' => 'https://images.unsplash.com/photo-1576107232684-1279f390859f?w=400'],
            ['category_id' => 4, 'name' => 'Chicken Wings', 'description' => 'Sayap ayam pedas manis', 'price' => 48000, 'image_path' => 'https://images.unsplash.com/photo-1608039755401-742074f0548d?w=400'],
        ];

        foreach ($menus as $menu) {
            \App\Models\Menu::create($menu);
        }

        // Seed Tables (Meja)
        for ($i = 1; $i <= 10; $i++) {
            \App\Models\Table::create([
                'table_number' => (string)$i,
                'name' => "Meja $i",
                'status' => 'available',
                'qr_code' => "qr_meja_$i.png",
            ]);
        }

        // Seed Orders
        $this->call([
            OrderSeeder::class,
        ]);
    }
}
