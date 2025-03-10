<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items' => function($query) {
            $query->latest();
        }]);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Order $order)
    {
        $validated = request()->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order->update($validated);

        return back()->with('success', 'Order status updated successfully');
    }

    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->delete();
        
        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully');
    }

}
