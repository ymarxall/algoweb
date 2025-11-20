<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerMenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Kasir\DashboardController;
use App\Http\Controllers\Kasir\OrderController;
use Illuminate\Support\Facades\Route;

// ===============================================
// 1. Halaman Umum (bisa diakses semua orang)
// ===============================================

Route::get('/', function () {
    return view('welcome');
});

// MENU PELANGGAN – Sekarang pakai Controller (ambil data dari database)
Route::get('/meja/{no?}', [CustomerMenuController::class, 'showMenu'])
    ->where('no', '[0-9]+')
    ->name('customer.menu');

// API untuk fetch menu data (AJAX)
Route::get('/api/menus', [CustomerMenuController::class, 'getMenus'])->name('api.menus');

// API untuk fetch order status (untuk waiting page)
Route::get('/api/orders/{id}', function ($id) {
    $order = \App\Models\Order::findOrFail($id);
    return response()->json([
        'id' => $order->id,
        'order_number' => $order->order_number,
        'status' => $order->status,
        'estimated_completion_at' => $order->estimated_completion_at,
        'estimated_minutes' => $order->estimated_minutes,
        'menus' => $order->menus->map(fn($m) => [
            'name' => $m->name,
            'quantity' => $m->pivot->quantity,
            'price' => $m->pivot->price,
        ]),
    ]);
})->name('api.order.status');

// CART Operations (AJAX)
Route::post('/cart/add', [CartController::class, 'add'])
    ->middleware('throttle:60,1')
    ->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])
    ->middleware('throttle:60,1')
    ->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])
    ->middleware('throttle:60,1')
    ->name('cart.remove');

// CHECKOUT
Route::post('/checkout', [CheckoutController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('checkout.store');

// WAITING PAGE
Route::get('/waiting/{orderId?}', function ($orderId = null) {
    $order = null;
    if ($orderId) {
        $order = \App\Models\Order::with('menus', 'table')->find($orderId);
    }
    return view('customer.waiting', compact('order'));
})->name('customer.waiting');

// ORDER SUCCESS
Route::get('/order-success/{orderId}', function ($orderId) {
    $order = \App\Models\Order::findOrFail($orderId);
    return view('customer.order-success', compact('order'));
})->name('order.success');

// ===============================================
// 2. Kasir Dashboard Routes (require kasir role)
// ===============================================

Route::middleware(['auth', 'kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // API for dashboard AJAX updates
    Route::get('/api/dashboard', [DashboardController::class, 'apiData'])->name('api.dashboard');
    
    // Orders management
    Route::get('/orders', [DashboardController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/accept', [OrderController::class, 'accept'])->name('orders.accept');
    Route::post('/orders/{id}/reject', [OrderController::class, 'reject'])->name('orders.reject');
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    
    // History
    Route::get('/history', [DashboardController::class, 'history'])->name('history');
    
    // Revenue
    Route::get('/revenue', [DashboardController::class, 'revenue'])->name('revenue');
});

// ===============================================
// 3. Halaman yang butuh login (dari Breeze)
// ===============================================

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===============================================
// 4. Auth routes (login, register, forgot password, dll)
// ===============================================

require __DIR__.'/auth.php';