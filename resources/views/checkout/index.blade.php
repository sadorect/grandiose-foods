@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-lime-900 mb-8">Checkout</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Order Summary -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                @foreach($products as $product)
                    <div class="flex items-center justify-between border-b py-4">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('images/products/' . $product->id . '.jpg') }}" 
                                 alt="{{ $product->name }}"
                                 class="w-16 h-16 object-cover rounded-lg">
                            <div>
                                <h3 class="font-semibold">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-600">
                                    Quantity: {{ $cartItems[$product->id]['quantity'] }}
                                </p>
                            </div>
                        </div>
                        <span class="font-bold text-lime-800">
                            ${{ number_format($cartItems[$product->id]['quantity'] * $cartItems[$product->id]['price'], 2) }}
                        </span>
                    </div>
                @endforeach
                
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>${{ number_format($subtotal = $products->sum(function($product) use ($cartItems) {
                            return $cartItems[$product->id]['quantity'] * $cartItems[$product->id]['price'];
                        }), 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Tax (10%)</span>
                        <span>${{ number_format($tax = $subtotal * 0.10, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lime-900 text-lg pt-2 border-t">
                        <span>Total</span>
                        <span>${{ number_format($subtotal + $tax, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Shipping Information</h2>
                <form action="{{ route('orders.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Company Name</label>
                        <input type="text" name="company_name" 
                               class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500" 
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contact Name</label>
                        <input type="text" name="contact_name" 
                               class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500" 
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" 
                               class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500" 
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="tel" name="phone" 
                               class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500" 
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Shipping Address</label>
                        <textarea name="shipping_address" rows="3" 
                                  class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500" 
                                  required></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Billing Address</label>
                        <textarea name="billing_address" rows="3" 
                                  class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500" 
                                  required></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                        <select name="payment_method" 
                                class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500" 
                                required>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="credit_card">Credit Card</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" rows="2" 
                                  class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500"></textarea>
                    </div>

                    <button type="submit" 
                            class="w-full bg-lime-600 text-white py-3 px-6 rounded-lg hover:bg-lime-700 transition">
                        Place Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection