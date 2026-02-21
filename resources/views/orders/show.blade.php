@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6 bg-lime-50">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold text-lime-900">Order #{{ $order->order_number }}</h1>
                    <p class="text-gray-600">Placed on {{ $order->created_at->format('F j, Y') }}</p>
                </div>
                <span class="px-4 py-2 rounded-full text-sm font-medium
                    @if($order->status === 'delivered') bg-green-100 text-green-800
                    @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                    @else bg-yellow-100 text-yellow-900
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h2 class="text-lg font-medium text-lime-900 mb-2">Shipping Address</h2>
                    <div class="bg-gray-50 rounded p-4">
                        <p>{{ $order->shipping_address['street'] ?? 'street' }}</p>
                        <p>{{ $order->shipping_address['city'] ?? 'city' }}, {{ $order->shipping_address['state'] ?? 'state' }} {{ $order->shipping_address['zip'] ?? 'zip' }}</p>
                    </div>
                </div>
                <div>
                    <h2 class="text-lg font-medium text-lime-900 mb-2">Payment Information</h2>
                    <div class="bg-gray-50 rounded p-4">
                        <p>Method: {{ ucfirst($order->payment_method) }}</p>
                        <p>Status: {{ ucfirst($order->payment_status) }}</p>
                    </div>
                </div>
            </div>

            <table class="w-full mb-6">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="px-6 py-4">{{ $item->product_name }}</td>
                            <td class="px-6 py-4">{{ $item->quantity }}</td>
                            <td class="px-6 py-4">${{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-6 py-4">${{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="border-t border-gray-200 pt-4">
                <div class="flex justify-end">
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt>Subtotal</dt>
                            <dd>${{ number_format($order->subtotal, 2) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Tax</dt>
                            <dd>${{ number_format($order->tax, 2) }}</dd>
                        </div>
                        <div class="flex justify-between text-lime-900 font-medium">
                            <dt>Total</dt>
                            <dd>${{ number_format($order->total, 2) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>


<!-- Add this after the main order details div -->
<div class="mt-8 flex justify-between items-center">
    <div class="space-x-4">
        <a href="{{ route('profile.orders') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
            ← Back to Orders
        </a>
        <a href="{{ route('products.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-lime-700 text-white rounded-lg hover:bg-lime-800">
            Continue Shopping
        </a>
    </div>
    
    <button onclick="reorderItems({{ $order->id }})"
            class="px-4 py-2 bg-lime-100 text-lime-700 rounded-lg hover:bg-lime-200">
        Reorder Items
    </button>
</div>


</div>
@endsection
