<div class="p-6">
    <!-- Orders List -->
    <div class="space-y-6">
        @forelse(auth()->user()->orders()->latest()->get() as $order)
            <div class="bg-yellow-50 border border-lime-200 rounded-lg overflow-hidden">
                <!-- Order Header -->
                <div class="p-4 flex justify-between items-center border-b border-lime-200">
                    <div>
                        <h3 class="font-medium text-lime-900">Order #{{ $order->order_number }}</h3>
                        <p class="text-sm text-gray-600">{{ $order->created_at->format('F j, Y') }}</p>
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
                        <span class="font-medium text-lime-900">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="p-4">
                    <table class="w-full">
                        <thead class="text-left text-sm text-gray-600">
                            <tr>
                                <th class="pb-2">Product</th>
                                <th class="pb-2">Quantity</th>
                                <th class="pb-2">Price</th>
                                <th class="pb-2">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="py-2">{{ $item->product_name }}</td>
                                    <td class="py-2">{{ $item->quantity }} {{ $item->measurement_unit }}</td>
                                    <td class="py-2">${{ number_format($item->unit_price, 2) }}</td>
                                    <td class="py-2">${{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-t border-lime-200">
                            <tr>
                                <td colspan="3" class="text-right py-2">Subtotal:</td>
                                <td class="py-2">${{ number_format($order->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right py-2">Tax:</td>
                                <td class="py-2">${{ number_format($order->tax, 2) }}</td>
                            </tr>
                            <tr class="font-medium">
                                <td colspan="3" class="text-right py-2">Total:</td>
                                <td class="py-2">${{ number_format($order->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Order Actions -->
                <div class="p-4 bg-white border-t border-lime-200">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            <p>Shipping to:  {{ $order->shipping_address_city ?? 'city' }}, {{ $order->shipping_address_state ?? 'state' }}<br>
                                {{ $order->shipping_address_postal_code ?? 'zip' }}<br>
                                {{ $order->shipping_address_country  ?? 'country'}}</p>
                        </div>
                        <div class="flex space-x-4">
                            <button onclick="window.location='{{ route('orders.show', $order) }}'"
                                    class="text-lime-600 hover:text-lime-700">
                                View Details
                            </button>
                            <button onclick="reorderItems({{ $order->id }})"
                                type="button"
                                class="text-lime-600 hover:text-lime-700">
                            Reorder
                        </button>
                        
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <p class="text-gray-500">No orders found</p>
                <a href="{{ route('products.index') }}" 
                   class="mt-4 inline-block text-lime-600 hover:text-lime-700">
                    Start Shopping →
                </a>
            </div>
        @endforelse
    </div>
</div>

<script>
function reorderItems(orderId) {
    console.log('Starting reorder request for order:', orderId);
    fetch(`/orders/${orderId}/reorder`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        console.log('Raw response:', response);
        return response.json();
    })
    .then(data => {
        console.log('Parsed data:', data);
        if (data.success) {
            window.location.href = '/cart';
        }
    })
    .catch(error => console.log('Error:', error));
}

</script>
