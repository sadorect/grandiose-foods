<div class="p-6">
    <!-- Orders List -->
    <div class="space-y-6">
        @forelse($orders ?? [] as $order)
            <div class="bg-yellow-50 border border-lime-200 rounded-lg overflow-hidden">
                <div class="p-4 flex justify-between items-center border-b border-lime-200">
                    <div>
                        <h3 class="font-medium text-lime-900">Order #{{ $order->order_number }}</h3>
                        <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('M d, Y') }}</p>
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
                        <span class="font-medium text-lime-900">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>

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
                    </table>
                </div>

                <div class="p-4 bg-white border-t border-lime-200">
                    <div class="flex justify-end space-x-4">
                        <button class="text-lime-600 hover:text-lime-700">View Details</button>
                        <button class="text-lime-600 hover:text-lime-700">Reorder</button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <p class="text-gray-500">No orders found</p>
                <a href="{{ route('products.index') }}" class="mt-4 inline-block text-lime-600 hover:text-lime-700">
                    Start Shopping →
                </a>
            </div>
        @endforelse
    </div>
</div>
