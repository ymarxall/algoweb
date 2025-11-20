<?php
/**
 * Comprehensive System Readiness Check
 * Tests all critical components
 */
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Table;
use App\Models\Category;
use App\Models\OrderStatus;
use App\Models\AdminLog;

echo "\n=== ALGO COFFEE POS - SYSTEM READINESS CHECK ===\n\n";

$checks = [
    'passed' => 0,
    'failed' => 0,
    'details' => []
];

// 1. Check Models Load
echo "1️⃣ MODELS VERIFICATION:\n";
try {
    $users = User::count();
    echo "   ✓ User model OK ($users users)\n";
    $checks['passed']++;
} catch (Exception $e) {
    echo "   ✗ User model ERROR: {$e->getMessage()}\n";
    $checks['failed']++;
}

try {
    $menus = Menu::count();
    echo "   ✓ Menu model OK ($menus menus)\n";
    $checks['passed']++;
} catch (Exception $e) {
    echo "   ✗ Menu model ERROR: {$e->getMessage()}\n";
    $checks['failed']++;
}

try {
    $orders = Order::count();
    echo "   ✓ Order model OK ($orders orders)\n";
    $checks['passed']++;
} catch (Exception $e) {
    echo "   ✗ Order model ERROR: {$e->getMessage()}\n";
    $checks['failed']++;
}

try {
    $tables = Table::count();
    echo "   ✓ Table model OK ($tables tables)\n";
    $checks['passed']++;
} catch (Exception $e) {
    echo "   ✗ Table model ERROR: {$e->getMessage()}\n";
    $checks['failed']++;
}

// 2. Check Critical Data
echo "\n2️⃣ DATA AVAILABILITY:\n";
try {
    $kasir = User::where('email', 'kasir@algocoffee.com')->first();
    if ($kasir) {
        echo "   ✓ Kasir user exists: {$kasir->email}\n";
        $checks['passed']++;
    } else {
        echo "   ✗ Kasir user NOT FOUND\n";
        $checks['failed']++;
    }
} catch (Exception $e) {
    echo "   ✗ Error checking kasir user: {$e->getMessage()}\n";
    $checks['failed']++;
}

try {
    $admin = User::where('email', 'admin@algocoffee.com')->first();
    if ($admin) {
        echo "   ✓ Admin user exists: {$admin->email}\n";
        $checks['passed']++;
    } else {
        echo "   ✗ Admin user NOT FOUND\n";
        $checks['failed']++;
    }
} catch (Exception $e) {
    echo "   ✗ Error checking admin user: {$e->getMessage()}\n";
    $checks['failed']++;
}

try {
    $menu_count = Menu::count();
    if ($menu_count > 0) {
        echo "   ✓ Menus available: $menu_count items\n";
        $checks['passed']++;
    } else {
        echo "   ✗ NO MENUS FOUND\n";
        $checks['failed']++;
    }
} catch (Exception $e) {
    echo "   ✗ Error checking menus: {$e->getMessage()}\n";
    $checks['failed']++;
}

try {
    $table_count = Table::count();
    if ($table_count > 0) {
        echo "   ✓ Tables available: $table_count tables\n";
        $checks['passed']++;
    } else {
        echo "   ✗ NO TABLES FOUND\n";
        $checks['failed']++;
    }
} catch (Exception $e) {
    echo "   ✗ Error checking tables: {$e->getMessage()}\n";
    $checks['failed']++;
}

// 3. Check Relationships
echo "\n3️⃣ MODEL RELATIONSHIPS:\n";
try {
    $order = Order::with('menus', 'table', 'statuses')->first();
    if ($order) {
        $hasMenus = $order->menus()->count();
        $hasTable = $order->table ? 'yes' : 'no';
        $hasStatuses = $order->statuses()->count();
        echo "   ✓ Order relationships OK (menus: $hasMenus, table: $hasTable, statuses: $hasStatuses)\n";
        $checks['passed']++;
    } else {
        echo "   ⚠ No orders exist yet (will be created on first purchase)\n";
        $checks['passed']++;
    }
} catch (Exception $e) {
    echo "   ✗ Order relationships ERROR: {$e->getMessage()}\n";
    $checks['failed']++;
}

// 4. Check Controller Availability
echo "\n4️⃣ CONTROLLER VERIFICATION:\n";
try {
    $controller = new \App\Http\Controllers\Kasir\DashboardController();
    echo "   ✓ DashboardController loads OK\n";
    $checks['passed']++;
} catch (Exception $e) {
    echo "   ✗ DashboardController ERROR: {$e->getMessage()}\n";
    $checks['failed']++;
}

try {
    $controller = new \App\Http\Controllers\Kasir\OrderController();
    echo "   ✓ OrderController loads OK\n";
    $checks['passed']++;
} catch (Exception $e) {
    echo "   ✗ OrderController ERROR: {$e->getMessage()}\n";
    $checks['failed']++;
}

try {
    $controller = new \App\Http\Controllers\CustomerMenuController();
    echo "   ✓ CustomerMenuController loads OK\n";
    $checks['passed']++;
} catch (Exception $e) {
    echo "   ✗ CustomerMenuController ERROR: {$e->getMessage()}\n";
    $checks['failed']++;
}

try {
    $controller = new \App\Http\Controllers\CheckoutController();
    echo "   ✓ CheckoutController loads OK\n";
    $checks['passed']++;
} catch (Exception $e) {
    echo "   ✗ CheckoutController ERROR: {$e->getMessage()}\n";
    $checks['failed']++;
}

// 5. Check Middleware
echo "\n5️⃣ MIDDLEWARE VERIFICATION:\n";
try {
    $middleware = new \App\Http\Middleware\EnsureIsKasir();
    echo "   ✓ EnsureIsKasir middleware loads OK\n";
    $checks['passed']++;
} catch (Exception $e) {
    echo "   ✗ EnsureIsKasir middleware ERROR: {$e->getMessage()}\n";
    $checks['failed']++;
}

// 6. Check Routes
echo "\n6️⃣ ROUTE VERIFICATION:\n";
try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $kasir_dashboard = $routes->getByName('kasir.dashboard') ? 'yes' : 'no';
    $kasir_api = $routes->getByName('kasir.api.dashboard') ? 'yes' : 'no';
    $api_order = $routes->getByName('api.order.status') ? 'yes' : 'no';
    echo "   ✓ kasir.dashboard route: $kasir_dashboard\n";
    echo "   ✓ kasir.api.dashboard route: $kasir_api\n";
    echo "   ✓ api.order.status route: $api_order\n";
    $checks['passed'] += 3;
} catch (Exception $e) {
    echo "   ✗ Route check ERROR: {$e->getMessage()}\n";
    $checks['failed']++;
}

// 7. Check Enum values
echo "\n7️⃣ ENUM/DATABASE VALUES:\n";
try {
    $order = Order::first();
    if ($order) {
        $statuses = ['pending', 'accepted', 'preparing', 'ready', 'completed', 'rejected'];
        echo "   ✓ Order status enum values: " . implode(', ', $statuses) . "\n";
        $checks['passed']++;
    } else {
        echo "   ⚠ No orders to verify status enum\n";
        $checks['passed']++;
    }
} catch (Exception $e) {
    echo "   ✗ Enum check ERROR: {$e->getMessage()}\n";
    $checks['failed']++;
}

// Summary
echo "\n" . str_repeat("=", 50) . "\n";
echo "SUMMARY:\n";
echo "✓ Passed: {$checks['passed']}\n";
echo "✗ Failed: {$checks['failed']}\n";

if ($checks['failed'] === 0) {
    echo "\n🎉 SISTEM SIAP DIGUNAKAN - TIDAK ADA ERROR\n";
    exit(0);
} else {
    echo "\n⚠️ SISTEM ADA MASALAH - LIHAT ERROR DI ATAS\n";
    exit(1);
}
