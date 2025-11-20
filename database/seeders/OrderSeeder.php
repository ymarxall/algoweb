<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Menu;
use App\Models\Table;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = Menu::all();
        $tables = Table::all();

        // Create 15 test orders
        for ($i = 0; $i < 15; $i++) {
            $status = ['pending', 'accepted', 'preparing', 'ready', 'completed', 'cancelled'][rand(0, 5)];
            $paymentMethod = rand(0, 1) ? 'cash' : 'card';
            
            $order = Order::create([
                'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid()) . $i,
                'table_id' => $tables->random()->id,
                'customer_name' => 'Customer ' . ($i + 1),
                'payment_method' => $paymentMethod,
                'total_price' => rand(50000, 300000),
                'subtotal' => rand(50000, 300000),
                'discount' => rand(0, 50000),
                'additional_charges' => rand(0, 10000),
                'status' => $status,
                'created_at' => Carbon::now()->subDays(rand(0, 30)),
                'updated_at' => Carbon::now()->subDays(rand(0, 30)),
            ]);

            // Add menu items to order
            $selectedMenus = $menus->random(rand(1, 4));
            foreach ($selectedMenus as $menu) {
                $order->menus()->attach($menu->id, [
                    'quantity' => rand(1, 3),
                    'price' => $menu->price,
                ]);
            }

            // Create status history
            $statuses = [];
            if ($status !== 'pending') {
                $statuses[] = ['pending', $order->created_at];
            }
            if (in_array($status, ['accepted', 'preparing', 'ready', 'completed'])) {
                $statuses[] = ['accepted', $order->created_at->addMinutes(2)];
            }
            if (in_array($status, ['preparing', 'ready', 'completed'])) {
                $statuses[] = ['preparing', $order->created_at->addMinutes(5)];
            }
            if (in_array($status, ['ready', 'completed'])) {
                $statuses[] = ['ready', $order->created_at->addMinutes(15)];
            }
            if ($status === 'completed') {
                $statuses[] = ['completed', $order->created_at->addMinutes(20)];
            }
            if ($status === 'cancelled') {
                $statuses[] = ['cancelled', $order->created_at->addMinutes(2)];
            }

            foreach ($statuses as [$s, $time]) {
                OrderStatus::create([
                    'order_id' => $order->id,
                    'status' => $s,
                    'notes' => null,
                    'status_at' => $time,
                    'changed_by' => 1,
                ]);
            }
        }
    }
}
