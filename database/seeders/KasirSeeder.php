<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class KasirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test kasir user
        User::create([
            'name' => 'Kasir Test',
            'email' => 'kasir@algocoffee.com',
            'password' => bcrypt('password123'),
            'role' => 'kasir',
            'status' => 'active',
            'phone' => '081234567890',
            'email_verified_at' => now(),
        ]);

        // Create test admin user
        User::create([
            'name' => 'Admin Algo',
            'email' => 'admin@algocoffee.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'status' => 'active',
            'phone' => '081234567891',
            'email_verified_at' => now(),
        ]);

        // Create another kasir
        User::create([
            'name' => 'Kasir Kedua',
            'email' => 'kasir2@algocoffee.com',
            'password' => bcrypt('password123'),
            'role' => 'kasir',
            'status' => 'active',
            'phone' => '081234567892',
            'email_verified_at' => now(),
        ]);
    }
}
