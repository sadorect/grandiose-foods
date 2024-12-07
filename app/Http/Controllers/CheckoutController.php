<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
{
    $cart = Cart::where('user_id', auth()->id())->with('items.product')->firstOrFail();
    $cartItems = $cart->items;
    $products = $cartItems->pluck('product');
    $addresses = auth()->user()->addresses;
    
    return view('checkout.index', compact('cart', 'cartItems', 'products', 'addresses'));
}


public function store(Request $request)
{
    try {
        DB::beginTransaction();
        
        // 1. Get cart first to ensure it exists
        $cart = Cart::where('user_id', auth()->id())
            ->with('items.product')
            ->firstOrFail();
            
        // 2. Validate the request
        $validated = $request->validate([
            'shipping_address_id' => 'required|string',
            'payment_method' => 'required|in:credit_card,bank_transfer',
            'company_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'new_address' => 'nullable|array|required_if:shipping_address_id,new',
            'new_address.label' => 'nullable|string|max:255|required_if:shipping_address_id,new',
            'new_address.street' => 'nullable|string|max:255|required_if:shipping_address_id,new',
            'new_address.city' => 'nullable|string|max:255|required_if:shipping_address_id,new',
            'new_address.state' => 'nullable|string|max:255|required_if:shipping_address_id,new',
            'new_address.zip' => 'nullable|string|max:20|required_if:shipping_address_id,new'
        ]);
    
        // After getting the address but before order creation
        
       
        // 3. Handle address
        if ($validated['shipping_address_id'] === 'new') {
            $address = auth()->user()->addresses()->create($validated['new_address']);
        } else {
            $address = auth()->user()->addresses()->findOrFail($validated['shipping_address_id']);
        }

       
        // 4. Calculate totals
        $subtotal = $cart->items->sum(fn($item) => $item->price * $item->quantity);
        $tax = $subtotal * 0.1;
        $total = $subtotal + $tax;


            // 5. Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'subtotal' => $cart->subtotal,
                'tax' => $cart->tax,
                'total' => $cart->total,
                'status' => 'pending',
                'shipping_address' => $address->toArray(),
                'billing_address' => $address->toArray(),
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'company_name' => $request->company_name,
        'contact_name' => $request->contact_name,
        'email' => $request->email,
        'phone' => $request->phone
            ]);
        
            // After order creation, before items creation

        // 6. Create order items
        foreach($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'quantity' => $item->quantity,
                'unit_price' => $item->price,
                'subtotal' => $item->price * $item->quantity,
                'size' => $item->product->size ?? '1', // Add default or get from product
            'measurement_unit' => $firstVariant['unit'] ?? 'unit',
            ]);
        }

     
        // 7. Delete cart
        $cart->delete();

        DB::commit();

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order placed successfully!');

         } catch (Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Order processing failed: ' . $e->getMessage());
        }
    }

}
