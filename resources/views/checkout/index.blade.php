@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-lime-900 mb-8">Checkout</h1>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Order Summary -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                @foreach($cart->items as $item)
                    <div class="flex items-center justify-between border-b py-4">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('images/products/' . $item->product->id . '.jpg') }}" 
                                 alt="{{ $item->product->name }}"
                                 class="w-16 h-16 object-cover rounded-lg">
                            <div>
                                <h3 class="font-semibold">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-600">
                                    Quantity: {{ $item->quantity }}
                                </p>
                            </div>
                        </div>
                        <span class="font-bold text-lime-800">
                            ${{ number_format($item->subtotal, 2) }}
                        </span>
                    </div>
                @endforeach
                
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>${{ number_format($cart->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Tax (10%)</span>
                        <span>${{ number_format($cart->tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lime-900 text-lg pt-2 border-t">
                        <span>Total</span>
                        <span>${{ number_format($cart->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

<div class="bg-white rounded-lg shadow-md p-6 space-y-6"> <!-- Added more padding and spacing -->
            <h2 class="text-xl font-semibold mb-6 text-lime-900 border-b pb-2">Shipping Information</h2> <!-- Enhanced header -->
    <!-- Checkout Form -->
        <form action="{{ route('checkout.store') }}" method="POST" type="submit">
            @csrf

            @if ($errors->any())
            <div class="bg-red-100 p-4 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-600">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <div>
                <label class="block text-sm font-medium text-gray-700">Company Name</label>
                <input type="text" name="company_name" 
                class="mt-1 block w-full rounded-md border-lime-300 bg-lime-200 shadow-sm focus:border-lime-500 focus:ring-lime-500" 
                    required>
            </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Contact Name</label>
            <input type="text" name="contact_name" 
            class="mt-1 block w-full rounded-md border-lime-300 bg-lime-200 shadow-sm focus:border-lime-500 focus:ring-lime-500"  
                   required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" 
            class="mt-1 block w-full rounded-md border-lime-300 bg-lime-200 shadow-sm focus:border-lime-500 focus:ring-lime-500" 
                   required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Phone</label>
            <input type="tel" name="phone" 
            class="mt-1 block w-full rounded-md border-lime-300 bg-lime-200 shadow-sm focus:border-lime-500 focus:ring-lime-500"  
                   required>
        </div>
        <!-- Replace the shipping address section with this -->
        <div class="mx-4 my-4">
            <label class="block text-sm font-medium text-gray-700 mb-2"><strong>Select Shipping Address</strong></label>
            
            <!-- Saved Addresses -->
            @foreach($addresses as $address)
                <div class="mb-3">
                    <label class="flex items-start space-x-3">
                        <input type="radio" 
                            name="shipping_address_id" 
                            value="{{ $address->id }}" 
                            class="mt-1 rounded-full border-gray-300 text-lime-600 focus:ring-lime-500">
                        <span class="text-sm">
                            <strong>{{ $address->label }}</strong><br>
                            {{ $address->street }}<br>
                            {{ $address->city }}, {{ $address->state }} {{ $address->zip }}
                        </span>
                    </label>
                </div>
            @endforeach

            <!-- New Address Option -->
            <div class="mb-3">
                <label class="flex items-start space-x-3">
                    <input type="radio" 
                        name="shipping_address_id" 
                        value="new" 
                        class="mt-1 rounded-full border-gray-300 text-lime-600 focus:ring-lime-500">
                    <span class="text-sm font-medium">Use a new address</span>
                </label>
            </div>

            <!-- New Address Form (initially hidden) -->
            <div id="newAddressForm" class="hidden mt-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Address Label</label>
                    <input type="text" name="new_address[label]" 
                    class="mt-1 block w-full rounded-md border-lime-300 bg-lime-200 shadow-sm focus:border-lime-500 focus:ring-lime-500" >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Street Address</label>
                    <input type="text" name="new_address[street]" 
                    class="mt-1 block w-full rounded-md border-lime-300 bg-lime-200 shadow-sm focus:border-lime-500 focus:ring-lime-500" >
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">City</label>
                        <input type="text" name="new_address[city]" 
                        class="mt-1 block w-full rounded-md border-lime-300 bg-lime-200 shadow-sm focus:border-lime-500 focus:ring-lime-500" >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">State</label>
                        <input type="text" name="new_address[state]" 
                        class="mt-1 block w-full rounded-md border-lime-300 bg-lime-200 shadow-sm focus:border-lime-500 focus:ring-lime-500" >
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">ZIP Code</label>
                    <input type="text" name="new_address[zip]" 
                    class="mt-1 block w-full rounded-md border-lime-300 bg-lime-200 shadow-sm focus:border-lime-500 focus:ring-lime-500" >
                </div>
            </div>
        </div>

        <!-- Payment Method Selection -->
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
            <select name="payment_method" 
            class="mt-1 block w-full rounded-md border-lime-300 bg-lime-200 shadow-sm focus:border-lime-500 focus:ring-lime-500" >
                <option value="bank_transfer">Bank Transfer</option>
                <option value="credit_card">Credit Card</option>
            </select>
        </div>

        <!-- Place Order Button -->
        <div class="mt-8">
            <button type="submit" 
                    class="w-full bg-lime-600 text-white py-3 px-6 rounded-lg hover:bg-lime-700 transition">
                Place Order
            </button>
        </div>
     </form>

    </div>
</div>
</div>

<!-- Add this before closing body tag -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addressRadios = document.querySelectorAll('input[name="shipping_address_id"]');
        const newAddressForm = document.getElementById('newAddressForm');
    
        addressRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'new') {
                    newAddressForm.classList.remove('hidden');
                } else {
                    newAddressForm.classList.add('hidden');
                }
            });
        });
    });
    </script>
    
@endsection