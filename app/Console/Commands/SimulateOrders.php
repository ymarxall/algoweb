<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Menu;
use App\Models\Table;
use App\Models\OrderStatus;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class SimulateOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kasir:simulate-orders {count=5}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Buat beberapa order simulasi untuk pengujian dashboard kasir';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = (int) $this->argument('count');

        $menu = Menu::first();
        $table = Table::first();

        if (! $menu || ! $table) {
            $this->error('Tidak ada Menu atau Table di database. Tambahkan data sample terlebih dahulu.');
            return 1;
        }

        $this->info("Membuat {$count} order simulasi menggunakan menu pertama (ID: {$menu->id}) dan meja pertama (ID: {$table->id})");

        for ($i = 1; $i <= $count; $i++) {
            $now = Carbon::now()->subMinutes($i * 3);

            $order = Order::create([
                'order_number' => 'SIM' . strtoupper(Str::random(6)) . '-' . now()->format('Hi') . $i,
                'customer_name' => 'Test Customer ' . $i,
                'table_id' => $table->id,
                'subtotal' => $menu->price,
                'discount' => 0,
                'additional_charges' => 0,
                'total_price' => $menu->price,
                'final_total' => $menu->price,
                'payment_method' => 'cash',
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // attach menu item
            $order->menus()->attach($menu->id, ['quantity' => 1, 'price' => $menu->price]);

            // create initial order status
            OrderStatus::create([
                'order_id' => $order->id,
                'status' => 'pending',
                'notes' => 'Simulasi order dibuat',
                'changed_by' => null,
                'status_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->line("  - Order {$order->order_number} (ID: {$order->id}) dibuat.");
        }

        $this->info('Selesai membuat order simulasi.');
        return 0;
    }
}
