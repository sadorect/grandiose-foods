@extends('layouts.app')

@section('title', 'Wholesale Food Products Catalog')
@section('meta_description', 'Browse our extensive catalog of wholesale food products including grains, dried fruits, nuts, and more.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumbs -->
    <nav class="text-lime-800 mb-8" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li><a href="/" class="hover:text-lime-700">Home</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="font-semibold">Products</li>
        </ol>
    </nav>

    <!-- Filters and Search -->
    <div class="flex justify-between items-center mb-8">
        <div class="flex space-x-4">
            <form method="GET" action="{{ route('products.index') }}" class="flex items-center space-x-4">
                <select name="category" class="rounded-lg bg-yellow-200 border-gray-300" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </form>
            
        </div>
        <div>
            <input type="search" 
                   name="search" 
                   placeholder="Search products..." 
                   class="rounded-lg border-gray-300"
                   value="{{ request('search') }}">
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition">
                <!-- Replace existing image tag in product card -->
                <img src="{{ $product->images->first() ? Storage::url($product->images->first()->path) : asset('images/placeholder.jpg') }}" 
                alt="{{ $product->name }}"
                class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-lime-900">{{ $product->name }}</h3>
                    <p class="text-gray-600 text-sm mb-2">{{ $product->category->name }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-lime-800">
                            @php
                                $variants = json_decode($product->variants, true);
                                $basePrice = $variants[0]['price'] ?? $product->base_price;
                            @endphp
                            ${{ number_format($basePrice, 2) }}
                        </span>
                        <a href="{{ route('products.show', $product) }}" 
                           class="bg-lime-600 text-white px-4 py-2 rounded hover:bg-lime-700">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>
@endsection