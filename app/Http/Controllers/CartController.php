<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cartItems))->get();
        
        return view('cart.index', compact('cartItems', 'products'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:' . $product->min_order_quantity]
        ]);

        $cart = session()->get('cart', []);
        
        $cart[$product->id] = [
            'quantity' => $request->quantity,
            'price' => $product->base_price,
            'added_at' => now()
        ];
        
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Product added to cart');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        unset($cart[$product->id]);
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Product removed from cart');
    }


    public function updateQuantity(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:' . $product->min_order_quantity]
        ]);

        $cart = session()->get('cart', []);
        $cart[$product->id]['quantity'] = $request->quantity;
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Quantity updated'
        ]);
    }

}