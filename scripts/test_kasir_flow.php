<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Order;
use App\Http\Controllers\Kasir\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

echo "Starting kasir E2E scripted test...\n";

// Find kasir user
$kasir = User::where('email', 'kasir@algocoffee.com')->first();
if (! $kasir) {
    echo "Kasir user not found (kasir@algocoffee.com)\n";
    exit(1);
}

// Login as kasir
Auth::login($kasir);
echo "Logged in as kasir (id={$kasir->id})\n";

// Pick a pending order
$order = Order::where('status', 'pending')->first();
if (! $order) {
    echo "No pending order found to test.\n";
    exit(2);
}

echo "Using order id={$order->id} number={$order->order_number} status={$order->status}\n";

$controller = new OrderController();

// 1) Accept order
$req = Request::create('/kasir/orders/'.$order->id.'/accept', 'POST', [], [], [], ['REMOTE_ADDR' => '127.0.0.1']);
$response = $controller->accept($req, $order->id);
echo "Accept response type: " . (is_array($response) ? 'array' : get_class($response)) . "\n";
$order->refresh();
echo "Order status after accept: {$order->status}\n";

// 2) Update status to preparing with estimate 10 minutes
$req2 = Request::create('/kasir/orders/'.$order->id.'/status', 'POST', ['status' => 'preparing', 'estimated_minutes' => 10], [], [], ['REMOTE_ADDR' => '127.0.0.1']);
$response2 = $controller->updateStatus($req2, $order->id);
$order->refresh();
echo "Order status after updateStatus: {$order->status}\n";
echo "Estimated minutes: {$order->estimated_minutes}\n";
echo "Estimated completion at: {$order->estimated_completion_at}\n";

// 3) Update status to ready
$req3 = Request::create('/kasir/orders/'.$order->id.'/status', 'POST', ['status' => 'ready'], [], [], ['REMOTE_ADDR' => '127.0.0.1']);
$controller->updateStatus($req3, $order->id);
$order->refresh();
echo "Order status after ready: {$order->status}\n";

// 4) Mark as completed
$req4 = Request::create('/kasir/orders/'.$order->id.'/status', 'POST', ['status' => 'completed'], [], [], ['REMOTE_ADDR' => '127.0.0.1']);
$controller->updateStatus($req4, $order->id);
$order->refresh();
echo "Order status after completed: {$order->status}\n";
echo "Actual completion at: {$order->actual_completion_at}\n";

// 5) Verify /api/orders/{id} response includes estimated and actual fields
$apiUrl = "http://127.0.0.1:8000/api/orders/{$order->id}";
$raw = @file_get_contents($apiUrl);
if ($raw === false) {
    echo "Failed to GET $apiUrl — the server might not be running. Skipping HTTP verify.\n";
} else {
    echo "API response for order {$order->id}:\n";
    echo $raw . "\n";
}

echo "E2E scripted test finished.\n";
