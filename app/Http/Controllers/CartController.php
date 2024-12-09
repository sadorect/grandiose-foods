<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $cartItems = $cart->items()->with('product')->get();
        $products = $cartItems->pluck('product');

        return view('cart.index', compact('cartItems', 'products'));
        
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:' . $product->min_order_quantity]
        ]);

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        
        $cart->items()->updateOrCreate(
            ['product_id' => $product->id],
            [
                'quantity' => $request->quantity,
                'price' => $product->base_price
            ]
        );
        
        // Return JSON response for AJAX requests
            if($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product added to cart',
                    'cartCount' => $cart->items()->count()
                ]);
            }
        return redirect()->back()->with('success', $product->name.' added to cart.');
    }

    public function remove(Product $product)
    {
        $cart = Cart::where('user_id', auth()->id())->first();
        
        if ($cart) {
            $cart->items()->where('product_id', $product->id)->delete();
        }
        
        return redirect()->back()->with('success', 'Product removed from cart');
    }

    public function updateQuantity(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:' . $product->min_order_quantity]
        ]);

        $cart = Cart::where('user_id', auth()->id())->first();
        
        if ($cart) {
            $cart->items()->where('product_id', $product->id)
                ->update(['quantity' => $request->quantity]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Quantity updated'
        ]);
    }
}