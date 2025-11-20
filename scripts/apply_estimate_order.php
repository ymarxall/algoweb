<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

if ($argc < 3) {
    echo "Usage: php scripts/apply_estimate_order.php <order_id> <minutes>\n";
    exit(1);
}

$orderId = (int) $argv[1];
$minutes = (int) $argv[2];

use App\Models\Order;
use Carbon\Carbon;

$order = Order::find($orderId);
if (! $order) {
    echo "Order not found: $orderId\n";
    exit(2);
}

$order->estimated_minutes = $minutes;
$order->estimated_completion_at = Carbon::now()->addMinutes($minutes);
$order->save();

echo "Updated order {$order->id} with estimate {$order->estimated_minutes} minutes => {$order->estimated_completion_at}\n";
