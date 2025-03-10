@extends('layouts.app')

@section('content')
<!-- Add this at the top of the page -->
@if(session('success'))
    <div id="notification" class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
    </div>
@endif

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumbs -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li><a href="/" class="text-lime-600 hover:text-lime-700">Home</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('products.index') }}" class="text-lime-600 hover:text-lime-700">Products</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-700">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- Product Details -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Product Image -->
       <!-- Update image section -->
            <div x-data="{ mainImage: '{{ $product->images->first() ? Storage::url($product->images->first()->path) : asset('images/placeholder.jpg') }}' }">
                <!-- Main Image -->
                <img :src="mainImage" 
                    alt="{{ $product->name }}"
                    class="w-full rounded-lg shadow-lg mb-4">
                
                <!-- Thumbnails -->
                @if($product->images->count() > 1)
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($product->images as $image)
                            <img src="{{ Storage::url($image->path) }}" 
                                alt="{{ $product->name }}"
                                class="w-full h-24 object-cover rounded-lg cursor-pointer hover:opacity-75"
                                @click="mainImage = '{{ Storage::url($image->path) }}'">
                        @endforeach
                    </div>
                @endif
            </div>


        <!-- Product Info -->
        <div>
            <h1 class="text-3xl font-bold text-lime-900 mb-4">{{ $product->name }}</h1>
            <p class="text-gray-600 mb-4">{{ $product->description }}</p>
            
            <!-- Variants and Pricing -->
            <div class="bg-yellow-50 p-4 rounded-lg mb-6">
                @foreach(json_decode($product->variants, true) as $variant)
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-600">{{ $variant['size'] }} {{ $variant['unit'] }}:</span>
                        <span class="text-2xl font-bold text-lime-800"></span>
                    </div>
                @endforeach
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-600">Minimum Order:</span>
                    <span>{{ $product->min_order_quantity }} units</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Availability:</span>
                    <span class="text-lime-600">{{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}</span>
                </div>
            </div>

            <!-- Add to Cart Form -->
            <div class="grid grid-cols-2 gap-4">
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="quantity" class="block text-gray-700 mb-2">Quantity:</label>
                        <input type="number" 
                               name="quantity" 
                               id="quantity" 
                               min="{{ $product->min_order_quantity }}"
                               value="{{ $product->min_order_quantity }}"
                               class="w-full rounded-lg border-gray-300 bg-yellow-200">
                    </div>
                    <button type="submit" 
                            class="w-full bg-lime-600 text-white py-3 px-6 rounded-lg hover:bg-lime-700 transition">
                        Add to Cart
                    </button>
                </form>
                
                <div class="flex items-end">
                    <a href="{{ route('cart.index') }}" 
                       class="w-full bg-white text-lime-600 py-3 px-6 rounded-lg border border-lime-600 hover:bg-lime-50 transition text-center">
                        Go to Cart
                    </a>
                </div>
            </div>

            <!-- Specifications -->
            @if($product->specifications)
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-lime-900 mb-4">Specifications</h2>
                    <dl class="space-y-2">
                        @foreach(json_decode($product->specifications, true) as $key => $value)
                            <div class="flex justify-between">
                                <dt class="text-gray-600">{{ $key }}:</dt>
                                <dd>{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            @endif
        </div>
    </div>




    <!-- Related Products -->
    @if($related_products->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-lime-900 mb-8">Related Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach($related_products as $related)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition">
                        <img src="{{ $related->images->first() ? Storage::url($related->images->first()->path) : asset('images/placeholder.jpg') }}" 
                 alt="{{ $related->name }}" 
                             alt="{{ $related->name }}"
                             class="w-full h-48 object-cover rounded-t-lg">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-lime-900">{{ $related->name }}</h3>
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-xl font-bold text-lime-800">
                                    @php
                                       // $variants = json_decode($related->variants, true);
                                       // $basePrice = $variants[0]['price'] ?? $related->base_price;
                                    @endphp
                                    
                                </span>
                                <a href="{{ route('products.show', $related) }}" 
                                   class="text-lime-600 hover:text-lime-700">
                                    View →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<!-- Add this JavaScript -->
<script>
    document.getElementById('addToCartForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                quantity: document.getElementById('quantity').value
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Update cart count
                const cartCountElement = document.querySelector('[data-cart-count]');
        if(cartCountElement) {
            cartCountElement.textContent = data.cartCount;
            cartCountElement.style.display = data.cartCount > 0 ? '' : 'none';
        }
                
                // Show notification
                const notification = document.createElement('div');
                notification.className = 'fixed top-1/4 left-1/2 transform -translate-x-1/2 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50 shadow-lg';
                notification.textContent = data.message;
                document.body.appendChild(notification);
                
                // Remove notification after 3 seconds
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        });
    });
    </script>
@endsection
