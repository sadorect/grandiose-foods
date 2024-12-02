<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'payment_method' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $cartItems = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cartItems))->get();
        
        $subtotal = $products->sum(function($product) use ($cartItems) {
            return $cartItems[$product->id]['quantity'] * $cartItems[$product->id]['price'];
        });

        $tax = $subtotal * 0.10; // 10% tax rate
        $total = $subtotal + $tax;

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'status' => 'pending',
            'payment_status' => 'pending',
            'shipping_address' => json_encode($validated['shipping_address']),
            'billing_address' => json_encode($validated['billing_address']),
            ...$validated
        ]);

        foreach($products as $product) {
            $variant = json_decode($product->variants, true)[0]; // Get first variant
            $subtotal = $cartItems[$product->id]['quantity'] * $cartItems[$product->id]['price'];
            
            $order->items()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'unit_price' => $cartItems[$product->id]['price'],
                'quantity' => $cartItems[$product->id]['quantity'],
                'size' => $variant['size'],
                'measurement_unit' => $variant['unit'],
                'subtotal' => $subtotal
            ]);
        }

        session()->forget('cart');

        return redirect()->route('orders.confirmation', $order)
            ->with('success', 'Order placed successfully!');
    }

    public function confirmation(Order $order)
    {
        return view('orders.confirmation', compact('order'));
    }
}
