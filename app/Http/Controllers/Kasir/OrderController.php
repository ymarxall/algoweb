<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Accept/receive order
     */
    public function accept(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        DB::transaction(function () use ($order, $request) {
            // Update order status
            $order->update(['status' => 'accepted']);

            // Log status change
            OrderStatus::create([
                'order_id' => $order->id,
                'status' => 'accepted',
                'notes' => 'Pesanan diterima oleh kasir',
                'status_at' => now(),
                'changed_by' => auth()->id(),
            ]);

            // Log action
            AdminLog::create([
                'user_id' => auth()->id(),
                'action' => 'accept_order',
                'model' => 'Order',
                'model_id' => $order->id,
                'new_values' => ['status' => 'accepted'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        });

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Pesanan diterima']);
        }

        return redirect()->back()->with('success', 'Pesanan berhasil diterima');
    }

    /**
     * Reject/cancel order
     */
    public function reject(Request $request, $id)
    {
        $request->validate(['notes' => 'required|string|max:255']);
        $order = Order::findOrFail($id);

        DB::transaction(function () use ($order, $request) {
            $order->update(['status' => 'rejected']);

            OrderStatus::create([
                'order_id' => $order->id,
                'status' => 'rejected',
                'notes' => $request->notes,
                'status_at' => now(),
                'changed_by' => auth()->id(),
            ]);

            AdminLog::create([
                'user_id' => auth()->id(),
                'action' => 'reject_order',
                'model' => 'Order',
                'model_id' => $order->id,
                'new_values' => ['status' => 'rejected', 'notes' => $request->notes],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        });

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Pesanan ditolak']);
        }

        return redirect()->back()->with('success', 'Pesanan berhasil ditolak');
    }

    /**
     * Update order status and set estimate time
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,preparing,ready,completed',
            'notes' => 'nullable|string|max:255',
            'estimated_minutes' => 'nullable|integer|min:1|max:480',
        ]);

        $order = Order::findOrFail($id);

        DB::transaction(function () use ($order, $request) {
            $oldStatus = $order->status;

            // Update order
            $updateData = ['status' => $request->status];
            if ($request->estimated_minutes) {
                $updateData['estimated_minutes'] = (int) $request->estimated_minutes;
                $updateData['estimated_completion_at'] = now()->addMinutes((int)$request->estimated_minutes);
            }
            if ($request->status === 'completed') {
                $updateData['actual_completion_at'] = now();
                $updateData['completed_at'] = now();
            }

            $order->update($updateData);

            // Log status change
            OrderStatus::create([
                'order_id' => $order->id,
                'status' => $request->status,
                'notes' => $request->notes,
                'status_at' => now(),
                'changed_by' => auth()->id(),
            ]);

            // Log action
            AdminLog::create([
                'user_id' => auth()->id(),
                'action' => 'update_order_status',
                'model' => 'Order',
                'model_id' => $order->id,
                'old_values' => ['status' => $oldStatus],
                'new_values' => [
                    'status' => $request->status,
                    'estimated_minutes' => $request->estimated_minutes,
                    'notes' => $request->notes,
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        });

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Status pesanan diperbarui']);
        }

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
    }

    // Note: Price adjustment (discount/additional_charges) feature has been removed.
    // Prices are now fixed at checkout time and cannot be modified afterwards.

    /**
     * Get order details
     */
    public function show($id)
    {
        $order = Order::with('menus', 'table', 'statuses.user')->findOrFail($id);
        return view('kasir.dashboard.order-detail', compact('order'));
    }
}
