<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use App\Models\Order;
use App\Models\OrderStatus;

$id = $argv[1] ?? 1;
$minutes = $argv[2] ?? 15;
$order = Order::find($id);
if(! $order) { echo "Order $id not found\n"; exit(1); }
$order->status = 'preparing';
$order->estimated_minutes = (int)$minutes;
$order->estimated_completion_at = now()->addMinutes((int)$minutes);
$order->save();
OrderStatus::create([
    'order_id' => $order->id,
    'status' => 'preparing',
    'notes' => 'Simulasi set estimate via script',
    'status_at' => now(),
    'changed_by' => null,
]);

echo "Updated order {$order->id} with estimate {$order->estimated_minutes} minutes => {$order->estimated_completion_at}\n";
