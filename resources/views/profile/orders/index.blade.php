@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-lime-900 mb-8">My Orders</h1>

    <div class="space-y-6">
        @forelse($orders as $order)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Order Header -->
                <div class="p-4 bg-lime-50 border-b border-lime-100 flex justify-between items-center">
                    <div>
                        <h3 class="font-medium text-lime-900">
                            Order #{{ $order->order_number }}
                        </h3>
                        <p class="text-sm text-gray-600">
                            Placed on {{ $order->created_at->format('F j, Y') }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="px-3 py-1 rounded-full text-sm
                            @if($order->status === 'delivered') bg-green-100 text-green-800
                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                        <span class="font-medium text-lime-900">
                            ${{ number_format($order->total, 2) }}
                        </span>
                    </div>
                </div>

                <!-- Add this after the Order Header div and before Order Actions -->
                <div class="p-4">
                  <table class="w-full text-sm">
                      <thead class="text-gray-500">
                          <tr>
                              <th class="text-left py-2">Product</th>
                              <th class="text-left py-2">Quantity</th>
                              <th class="text-left py-2">Price</th>
                              <th class="text-right py-2">Subtotal</th>
                          </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200">
                          @foreach($order->items as $item)
                              <tr>
                                  <td class="py-2">{{ $item->product_name }}</td>
                                  <td class="py-2">{{ $item->quantity }}</td>
                                  <td class="py-2">${{ number_format($item->unit_price, 2) }}</td>
                                  <td class="py-2 text-right">${{ number_format($item->subtotal, 2) }}</td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
                </div>

                <!-- Order Actions -->
                <div class="p-4 bg-white flex justify-end space-x-4">
                    <a href="{{ route('orders.show', $order) }}" 
                       class="text-lime-600 hover:text-lime-700">
                        View Details
                    </a>
                    <button onclick="reorderItems({{ $order->id }})"
                            class="text-lime-600 hover:text-lime-700">
                        Reorder
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white rounded-lg shadow-md">
                <p class="text-gray-500 mb-4">You haven't placed any orders yet</p>
                <a href="{{ route('products.index') }}" 
                   class="text-lime-600 hover:text-lime-700">
                    Start Shopping →
                </a>
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</div>

<script>
function reorderItems(orderId) {
    fetch(`/orders/${orderId}/reorder`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '/cart';
        }
    });
}
</script>
@endsection
