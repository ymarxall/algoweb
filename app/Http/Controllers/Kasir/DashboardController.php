<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show dashboard home
     */
    public function index()
    {
        // Current status counts
        $pendingOrders = Order::where('status', 'pending')->count();
        $acceptedOrders = Order::where('status', 'accepted')->count();
        $preparingOrders = Order::where('status', 'preparing')->count();
        $readyOrders = Order::where('status', 'ready')->count();

        // Today's revenue (completed orders only)
        $todayRevenue = Order::whereDate('created_at', today())
            ->where('status', 'completed')
            ->sum('total_price');

        // Recent orders (all statuses)
        $recentOrders = Order::with('menus', 'table', 'statuses')
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();

        // Today's metrics
        $totalOrdersToday = Order::whereDate('created_at', today())->count();
        $completedOrdersToday = Order::whereDate('created_at', today())
            ->where('status', 'completed')
            ->count();

        // Calculate average time for completed orders today
        $completedOrdersWithTime = Order::whereDate('created_at', today())
            ->where('status', 'completed')
            ->whereNotNull('actual_completion_at')
            ->get();

        $averageTimeToday = 'N/A';
        if ($completedOrdersWithTime->count() > 0) {
            $totalMinutes = $completedOrdersWithTime->map(function ($order) {
                $createdTime = $order->created_at;
                $completedTime = $order->actual_completion_at;
                if ($completedTime && $createdTime) {
                    return $createdTime->diffInMinutes($completedTime);
                } 
                return 0;
            })->sum();
            $avgMinutes = round($totalMinutes / $completedOrdersWithTime->count());
            $averageTimeToday = $avgMinutes . ' menit';
        }

        // Top menus sold today
        $topMenusToday = Menu::selectRaw(
            'menus.id, 
            menus.name, 
            SUM(order_details.quantity) as count'
        )
        ->join('order_details', 'menus.id', '=', 'order_details.menu_id')
        ->join('orders', 'order_details.order_id', '=', 'orders.id')
        ->whereDate('orders.created_at', today())
        ->groupBy('menus.id', 'menus.name')
        ->orderBy('count', 'desc')
        ->limit(3)
        ->get();

        return view('kasir.dashboard.index', [
            'pendingOrders' => $pendingOrders,
            'acceptedOrders' => $acceptedOrders,
            'preparingOrders' => $preparingOrders,
            'readyOrders' => $readyOrders,
            'todayRevenue' => $todayRevenue,
            'totalOrdersToday' => $totalOrdersToday,
            'completedOrdersToday' => $completedOrdersToday,
            'averageTimeToday' => $averageTimeToday,
            'recentOrders' => $recentOrders,
            'topMenusToday' => $topMenusToday,
        ]);
    }

    /**
     * Return dashboard data as JSON for AJAX polling
     */
    public function apiData()
    {
        $pendingOrders = Order::where('status', 'pending')->count();
        $acceptedOrders = Order::where('status', 'accepted')->count();
        $preparingOrders = Order::where('status', 'preparing')->count();
        $readyOrders = Order::where('status', 'ready')->count();

        $todayRevenue = Order::whereDate('created_at', today())
            ->where('status', 'completed')
            ->sum('total_price');

        $recentOrders = Order::with('menus', 'table')
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer_name' => $order->customer_name,
                    'table_number' => $order->table->table_number ?? null,
                    'total_price' => $order->total_price,
                    'status' => $order->status,
                    'menus' => $order->menus->map(fn($m) => ['name' => $m->name, 'qty' => $m->pivot->quantity]),
                    'created_at' => $order->created_at->toDateTimeString(),
                ];
            });

        return response()->json([
            'counts' => [
                'pending' => $pendingOrders,
                'accepted' => $acceptedOrders,
                'preparing' => $preparingOrders,
                'ready' => $readyOrders,
            ],
            'pending' => $pendingOrders,
            'accepted' => $acceptedOrders,
            'preparing' => $preparingOrders,
            'ready' => $readyOrders,
            'todayRevenue' => $todayRevenue,
            'recentOrders' => $recentOrders,
        ]);
    }

    /**
     * Show all orders to manage
     */
    public function orders(Request $request)
    {
        $query = Order::with('menus', 'table')
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->status && in_array($request->status, ['pending', 'accepted', 'preparing', 'ready', 'completed', 'cancelled', 'rejected'])) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15);

        $stats = [
            'pending' => Order::where('status', 'pending')->count(),
            'accepted' => Order::where('status', 'accepted')->count(),
            'preparing' => Order::where('status', 'preparing')->count(),
            'ready' => Order::where('status', 'ready')->count(),
        ];

        return view('kasir.dashboard.orders', compact('orders', 'stats'));
    }

    /**
     * Show order history (grouped by month)
     */
    public function history(Request $request)
    {
        $month = $request->month ? Carbon::parse($request->month . '-01') : now();
        $year = $month->year;
        $monthNum = $month->month;

        $orders = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNum)
            ->with('menus', 'table')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Calculate stats for the selected month
        $monthOrders = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNum)
            ->get();

        $stats = [
            'total_orders' => $monthOrders->count(),
            'total_items' => $monthOrders->sum(fn($o) => $o->menus->sum(fn($m) => $m->pivot->quantity)),
            'total_revenue' => $monthOrders->sum('total_price'),
            'avg_order' => $monthOrders->count() > 0 ? round($monthOrders->sum('total_price') / $monthOrders->count()) : 0,
        ];

        return view('kasir.dashboard.history', compact('orders', 'month', 'stats'));
    }

    /**
     * Show revenue report
     */
    public function revenue(Request $request)
    {
        $view = $request->view ?? 'daily';
        $now = now();

        // Fetch all completed orders for the current year with their menu items
        $completedOrders = Order::with('menus')
            ->where('status', 'completed')
            ->whereYear('created_at', $now->year)
            ->get();

        if ($view === 'daily') {
            // Group by day for the current month
            $dailyData = $completedOrders
                ->filter(fn($order) => $order->created_at->month === $now->month)
                ->groupBy(fn($order) => $order->created_at->format('Y-m-d'))
                ->map(function ($dayOrders, $date) {
                    $totalOrders = $dayOrders->count();
                    $totalItems = $dayOrders->sum(fn($order) => $order->menus->sum('pivot.quantity'));
                    $totalRevenue = $dayOrders->sum('total_price');

                    return [
                        'date' => $date,
                        'total_orders' => $totalOrders,
                        'total_items' => $totalItems,
                        'total_revenue' => $totalRevenue,
                        'subtotal' => $totalRevenue, // Assuming subtotal is total_revenue for now
                    ];
                })
                ->sortBy('date')
                ->values();

            $revenues = $dailyData;

            $stats = [
                'total_revenue' => $revenues->sum('total_revenue'),
                'total_orders' => $revenues->sum('total_orders'),
                'avg_order' => $revenues->sum('total_orders') > 0 ? round($revenues->sum('total_revenue') / $revenues->sum('total_orders')) : 0,
            ];
        } else {
            // Group by month for the current year
            $monthlyData = $completedOrders
                ->groupBy(fn($order) => $order->created_at->format('Y-m'))
                ->map(function ($monthOrders, $monthKey) {
                    $totalOrders = $monthOrders->count();
                    $totalItems = $monthOrders->sum(fn($order) => $order->menus->sum('pivot.quantity'));
                    $totalRevenue = $monthOrders->sum('total_price');

                    return [
                        'year' => Carbon::parse($monthKey)->year,
                        'month' => Carbon::parse($monthKey)->month,
                        'date' => $monthKey . '-01',
                        'total_orders' => $totalOrders,
                        'total_items' => $totalItems,
                        'total_revenue' => $totalRevenue,
                        'subtotal' => $totalRevenue, // Assuming subtotal is total_revenue for now
                        'discount' => 0, // No discount field in orders table
                    ];
                })
                ->sortBy(fn($item) => $item['year'] . '-' . str_pad($item['month'], 2, '0', STR_PAD_LEFT))
                ->values();

            $revenues = $monthlyData;

            $stats = [
                'total_revenue' => $revenues->sum('total_revenue'),
                'total_orders' => $revenues->sum('total_orders'),
                'total_discount' => $revenues->sum('discount'),
                'avg_order' => $revenues->sum('total_orders') > 0 ? round($revenues->sum('total_revenue') / $revenues->sum('total_orders')) : 0,
            ];
        }

        // Top selling menus (re-calculate based on completed orders for the current year)
        $topMenus = $completedOrders
            ->flatMap(fn($order) => $order->menus->map(fn($menu) => ['menu' => $menu, 'quantity' => $menu->pivot->quantity, 'price' => $menu->pivot->price]))
            ->groupBy('menu.id')
            ->map(function ($items, $menuId) {
                $menu = $items->first()['menu'];
                $totalQuantity = $items->sum('quantity');
                $totalRevenue = $items->sum(fn($item) => $item['quantity'] * $item['price']);
                return [
                    'id' => $menu->id,
                    'name' => $menu->name,
                    'total_quantity' => $totalQuantity,
                    'total_revenue' => $totalRevenue,
                ];
            })
            ->sortByDesc('total_quantity')
            ->take(5)
            ->values();

        // Payment methods breakdown (re-calculate based on completed orders for the current year)
        $paymentMethods = $completedOrders
            ->groupBy('payment_method')
            ->map(function ($methodOrders, $paymentMethod) {
                return [
                    'payment_method' => $paymentMethod,
                    'total_orders' => $methodOrders->count(),
                    'total_revenue' => $methodOrders->sum('total_price'),
                ];
            })
            ->values();

        return view('kasir.dashboard.revenue', compact('revenues', 'stats', 'topMenus', 'paymentMethods', 'view'));
    }
}
