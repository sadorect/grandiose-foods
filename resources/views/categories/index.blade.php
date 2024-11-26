@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-lime-900 mb-8">Product Categories</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($categories as $category)
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition">
                <img src="{{ asset('images/categories/' . $category->slug . '.jpg') }}" 
                     alt="{{ $category->name }}"
                     class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-lime-900 mb-2">{{ $category->name }}</h2>
                    <p class="text-gray-600 mb-4">{{ $category->description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">{{ $category->products_count }} Products</span>
                        <a href="{{ route('categories.show', $category) }}" 
                           class="bg-lime-600 text-white px-4 py-2 rounded hover:bg-lime-700">
                            View Products
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
