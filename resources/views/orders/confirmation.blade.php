@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center mb-8">
        <svg class="mx-auto h-16 w-16 text-lime-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h1 class="mt-4 text-3xl font-bold text-lime-900">Order Confirmed!</h1>
        <p class="mt-2 text-gray-600">Your order number is: {{ $order->order_number }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4">Order Details</h2>
            
            <div class="grid grid-cols-2 gap-8">
                <div>
                    <h3 class="font-medium text-gray-700 mb-2">Shipping Information</h3>
                    <p class="text-gray-600">{{ $order->company_name }}</p>
                    <p class="text-gray-600">{{ $order->contact_name }}</p>
                    <p class="text-gray-600">{{ $order->shipping_address }}</p>
                    <p class="text-gray-600">{{ $order->email }}</p>
                    <p class="text-gray-600">{{ $order->phone }}</p>
                </div>

                <div>
                    <h3 class="font-medium text-gray-700 mb-2">Order Summary</h3>
                    @foreach($order->items as $item)
                        <div class="flex justify-between py-2 border-b">
                            <div>
                                <p class="font-medium">{{ $item->product->name }}</p>
                                <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                            </div>
                            <p class="font-medium">${{ number_format($item->price * $item->quantity, 2) }}</p>
                        </div>
                    @endforeach
                    
                    <div class="mt-4 text-right">
                        <p class="text-lg font-bold text-lime-900">
                            Total: ${{ number_format($order->total_amount, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-8">
        <a href="{{ route('products.index') }}" 
           class="text-lime-600 hover:text-lime-700">
            Continue Shopping →
        </a>
    </div>
</div>
@endsection
