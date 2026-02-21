<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
        'company_name' => 'required|string|max:255',
        'contact_name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string',
        'shipping_address' => 'required|string',
        'billing_address' => 'required|string',
        'payment_method' => 'required|in:bank_transfer,credit_card',
        'notes' => 'nullable|string'
    ]);

    $cart = Cart::where('user_id', Auth::id())->with('items.product')->firstOrFail();

    $order = Order::create([
        'company_name' => $validated['company_name'],
        'contact_name' => $validated['contact_name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
        'user_id' => Auth::id(),
        'order_number' => 'ORD-' . strtoupper(Str::random(8)),
        'subtotal' => $cart->subtotal,
        'tax' => $cart->tax,
        'total' => $cart->total,
        //'size' => $cart->size,
        'status' => 'pending',
        'shipping_address' => $validated['shipping_address'],
        'billing_address' => $validated['billing_address'],
        'payment_method' => $validated['payment_method'],
        'payment_status' => 'pending'
    ]);

    foreach($cart->items as $item) {
        $order->items()->create([
        'product_id' => $item->product_id,
        'product_name' => $item->product->name,
        'unit_price' => $item->price,
        'quantity' => $item->quantity,
        'size' => $item->product->size ?? '1', // Add default or get from product
        'measurement_unit' => $item->product->measurement_unit ?? 'kg', // Add default or get from product
        'subtotal' => $item->subtotal
        ]);
    }

    $cart->delete();

    return redirect()->route('orders.show', $order)
        ->with('success', 'Order placed successfully!');

    }

    public function confirmation(Order $order)
    {
        return view('orders.confirmation', compact('order'));
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    public function reorder(Order $order)
{
    abort_unless($order->user_id === Auth::id(), 403);

    try {
        $order->load('items');

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        
        foreach($order->items as $item) {
            $cart->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->unit_price
            ]);
        }

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        Log::error('Reorder failed: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    
}
