@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-lime-900 mb-8">Shopping Cart</h1>

    @if($cartItems->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-lime-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-lime-900">Product</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-lime-900">Price</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-lime-900">Quantity</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-lime-900">Subtotal</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img src="{{ asset('images/products/' . $item->product->id . '.jpg') }}" 
                                         alt="{{ $item->product->name }}"
                                         class="w-16 h-16 object-cover rounded">
                                    <div class="ml-4">
                                        <h3 class="text-lime-900 font-medium">{{ $item->product->name }}</h3>
                                        <p class="text-gray-500 text-sm">{{ $item->product->category->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-lime-900">${{ number_format($item->price, 2) }}</td>
                            <td class="px-6 py-4">
                                <input type="number" 
                                       value="{{ $item->quantity }}"
                                       min="{{ $item->product->min_order_quantity }}"
                                       class="w-20 rounded-lg border-lime-300 focus:border-lime-500 focus:ring-lime-500"
                                       onchange="updateQuantity({{ $item->product->id }}, this.value)">
                            </td>
                            <td class="px-6 py-4 text-lime-900 font-medium">
                                ${{ number_format($item->subtotal, 2) }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('cart.remove', $item->product) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="px-6 py-4 bg-lime-50">
                <div class="flex justify-between items-center">
                    <div class="text-lime-900">
                        <p class="text-lg font-medium">Total: ${{ number_format($cartItems->sum('subtotal'), 2) }}</p>
                    </div>
                    <a href="{{ route('checkout') }}" 
                       class="bg-lime-700 text-white px-6 py-2 rounded-lg hover:bg-lime-800 transition">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 mb-4">Your cart is empty</p>
            <a href="{{ route('products.index') }}" 
               class="text-lime-700 hover:text-lime-800">
                Continue Shopping →
            </a>
        </div>
    @endif
</div>

<script>
function updateQuantity(productId, quantity) {
    fetch(`/cart/${productId}/quantity`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    });
}
</script>
@endsection