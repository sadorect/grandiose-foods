@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumbs -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li><a href="/" class="text-lime-700 hover:text-lime-800">Home</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('categories.index') }}" class="text-lime-700 hover:text-lime-800">Categories</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-700">{{ $category->name }}</li>
        </ol>
    </nav>


     <!-- Category Header with Image -->
     <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="relative h-64 md:h-80">
            <img src="{{ $category->image }}" 
                 alt="{{ $category->name }}" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                <h1 class="text-3xl font-bold mb-2">{{ $category->name }}</h1>
                <p class="text-lg">{{ $category->description }}</p>
            </div>
        </div>
    </div>
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-lime-900 mb-4">{{ $category->name }}</h1>
        <p class="text-gray-600">{{ $category->description }}</p>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition">
                <img src="{{ $product->images->first() ? Storage::url($product->images->first()->path) : asset('images/placeholder.jpg') }}"  
                     alt="{{ $product->name }}"
                     class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-lime-900">{{ $product->name }}</h3>
                    <div class="flex justify-between items-center mt-4">
                        
                        <a href="{{ route('products.show', $product) }}" 
                           class="bg-lime-700 text-white px-4 py-2 rounded hover:bg-lime-800">
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
