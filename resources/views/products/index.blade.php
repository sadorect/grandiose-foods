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

    <!-- Filters -->
    <div class="grid grid-cols-4 gap-6">
        <div class="col-span-1 bg-white p-4 rounded-lg shadow">
            <h2 class="text-xl font-bold text-lime-900 mb-4">Filters</h2>
            <!-- Filter form here -->
        </div>

        <!-- Product Grid -->
        <div class="col-span-3">
            <div class="grid grid-cols-3 gap-6">
                @foreach($products as $product)
                    <article class="bg-white rounded-lg shadow hover:shadow-lg transition">
                        <img src="{{ $product->featured_image_url }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-48 object-cover rounded-t-lg">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-lime-900">{{ $product->name }}</h3>
                            <p class="text-gray-600 mt-2">{{ Str::limit($product->description, 100) }}</p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-xl font-bold text-lime-800">${{ $product->price }}</span>
                                <a href="{{ route('products.show', $product->slug) }}" 
                                   class="bg-lime-600 text-white px-4 py-2 rounded hover:bg-lime-700">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
