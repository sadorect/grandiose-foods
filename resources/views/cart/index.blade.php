@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-lime-900 mb-8">Shopping Cart</h1>

    @if(count($cartItems) > 0)
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 space-y-4">
                @foreach($products as $product)
                    <div class="flex items-center justify-between border-b pb-4">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('images/products/' . $product->id . '.jpg') }}" 
                                 alt="{{ $product->name }}"
                                 class="w-16 h-16 object-cover rounded-lg">
                            <div>
                                <h3 class="font-semibold text-lime-900">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-600">Quantity: {{ $cartItems[$product->id]['quantity'] }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-6">
                            <span class="font-bold text-lime-800">
                                ${{ number_format($cartItems[$product->id]['quantity'] * $cartItems[$product->id]['price'], 2) }}
                            </span>
                            
                            <form action="{{ route('cart.remove', $product) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <div class="flex justify-between items-center pt-4">
                    <div class="text-lg font-bold text-lime-900">
                        Total: ${{ number_format($products->sum(function($product) use ($cartItems) {
                            return $cartItems[$product->id]['quantity'] * $cartItems[$product->id]['price'];
                        }), 2) }}
                    </div>
                    
                    <a href="{{ route('checkout') }}" 
                       class="bg-lime-600 text-white px-6 py-3 rounded-lg hover:bg-lime-700 transition">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-600 mb-4">Your cart is empty</p>
            <a href="{{ route('products.index') }}" 
               class="text-lime-600 hover:text-lime-700">
                Continue Shopping →
            </a>
        </div>
    @endif
</div>
@endsection
