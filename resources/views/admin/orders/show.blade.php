@extends('layouts.admin')

@section('title', 'Order Details #' . $order->id)

@section('content')
<div class="bg-white rounded-lg shadow-md">
    <div class="p-6 border-b">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">Order #{{ $order->id }}</h2>
            <span class="px-3 py-1 rounded-full text-sm 
                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                   ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>
        <div class="mt-4 text-gray-600">
            <p>Ordered on: {{ $order->created_at->format('M d, Y H:i') }}</p>
            <p>Customer: {{ $order->user->name }}</p>
        </div>
    </div>

    <div class="p-6">
        <table class="w-full">
            <thead>
                <tr class="text-left border-b">
                    <th class="pb-4">Product</th>
                    <th class="pb-4">Size</th>
                    <th class="pb-4">Unit Price</th>
                    <th class="pb-4">Quantity</th>
                    <th class="pb-4 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr class="border-b">
                        <td class="py-4">{{ $item->product_name }}</td>
                        <td>{{ $item->size }} {{ $item->measurement_unit }}</td>
                        <td>${{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-right">${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="pt-4 text-right font-semibold">Subtotal:</td>
                    <td class="pt-4 text-right">${{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="pt-2 text-right font-semibold">Tax:</td>
                    <td class="pt-2 text-right">${{ number_format($order->tax, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="pt-2 text-right font-semibold">Total:</td>
                    <td class="pt-2 text-right font-bold">${{ number_format($order->total, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-8 grid grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold mb-2">Shipping Address</h3>
                <div class="text-gray-600">
                    {{ $order->shipping_address->address }}<br>
                    {{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }}<br>
                    {{ $order->shipping_address['postal_code'] }}<br>
                    {{ $order->shipping_address['country'] }}
                </div>
            </div>
            <div>
                <h3 class="font-semibold mb-2">Payment Information</h3>
                <div class="text-gray-600">
                    <p>Method: {{ ucfirst($order->payment_method) }}</p>
                    <p>Status: {{ ucfirst($order->payment_status) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
