@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-gray-500 text-sm font-medium mb-2">Total Products</h3>
        <div class="flex items-center">
            <span class="text-3xl font-bold text-lime-900">{{ $productsCount }}</span>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-gray-500 text-sm font-medium mb-2">Categories</h3>
        <div class="flex items-center">
            <span class="text-3xl font-bold text-lime-900">{{ $categoriesCount }}</span>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-gray-500 text-sm font-medium mb-2">Total Orders</h3>
        <div class="flex items-center">
            <span class="text-3xl font-bold text-lime-900">{{ $ordersCount }}</span>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-gray-500 text-sm font-medium mb-2">Total Customers</h3>
        <div class="flex items-center">
            <span class="text-3xl font-bold text-lime-900">{{ $customersCount }}</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Orders</h3>
        <table class="w-full">
            <thead class="text-left text-sm font-medium text-gray-500">
                <tr>
                    <th class="pb-3">Order ID</th>
                    <th class="pb-3">Customer</th>
                    <th class="pb-3">Amount</th>
                    <th class="pb-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr>
                    <td class="py-2">#{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                    <td>{{ $order->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Low Stock Products</h3>
        <table class="w-full">
            <thead class="text-left text-sm font-medium text-gray-500">
                <tr>
                    <th class="pb-3">Product</th>
                    <th class="pb-3">Stock</th>
                    <th class="pb-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lowStockProducts as $product)
                <tr>
                    <td class="py-2">{{ $product->name }}</td>
                    <td>{{ $product->stock_quantity }}</td>
                    <td>
                        <span class="px-2 py-1 text-xs rounded-full {{ $product->stock_quantity <= 10 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-900' }}">
                            {{ $product->stock_quantity <= 10 ? 'Critical' : 'Low' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
