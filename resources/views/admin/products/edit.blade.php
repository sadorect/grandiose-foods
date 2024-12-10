@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold">Edit Product: {{ $product->name }}</h2>
        </div>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected($category->id == $product->category_id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">SKU</label>
                    <input type="text" name="sku" value="{{ $product->sku }}" 
                           class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                    @error('sku')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text" name="name" value="{{ $product->name }}" 
                       class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="4" 
                          class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">{{ $product->description }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Base Price</label>
                    <input type="number" step="0.01" name="base_price" value="{{ $product->base_price }}"
                           class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                    @error('base_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Minimum Order Quantity</label>
                    <input type="number" name="min_order_quantity" value="{{ $product->min_order_quantity }}"
                           class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                    @error('min_order_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Measurement Type</label>
                    <select name="measurement_type" class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                        <option value="weight" @selected($product->measurement_type == 'weight')>Weight</option>
                        <option value="volume" @selected($product->measurement_type == 'volume')>Volume</option>
                    </select>
                    @error('measurement_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Stock Quantity</label>
                    <input type="number" name="stock_quantity" value="{{ $product->stock_quantity }}"
                           class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                    @error('stock_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Variants</label>
                <div class="space-y-2">
                    @foreach(json_decode($product->variants) as $index => $variant)
                        <div class="grid grid-cols-4 gap-4">
                            <input type="number" name="variants[{{ $index }}][size]" value="{{ $variant->size }}" 
                                   class="rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                            <input type="text" name="variants[{{ $index }}][unit]" value="{{ $variant->unit }}" 
                                   class="rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                            <input type="number" step="0.01" name="variants[{{ $index }}][price]" value="{{ $variant->price }}" 
                                   class="rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                            <input type="number" name="variants[{{ $index }}][stock]" value="{{ $variant->stock }}" 
                                   class="rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                        </div>
                    @endforeach
                </div>
                @error('variants')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Specifications</label>
                <textarea name="specifications" rows="3" 
                          class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">{{ json_encode($product->specifications, JSON_PRETTY_PRINT) }}</textarea>
                @error('specifications')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.products.index') }}" 
                   class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-lime-600 text-white rounded-md hover:bg-lime-700">
                    Update Product
                </button>
            </div>
        </form>
   

        <!-- Add before upload form -->
<div class="grid grid-cols-4 gap-4 mb-4">
    @foreach($product->images as $image)
        <div class="relative">
            <img src="{{ Storage::url($image->path) }}" 
                 alt="Product image" 
                 class="rounded-lg">
            <form action="{{ route('admin.products.images.destroy', [$product, $image]) }}" 
                  method="POST" 
                  class="absolute top-2 right-2">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-500 text-white p-1 rounded-full hover:bg-red-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </form>
        </div>
    @endforeach
</div>

        <!-- Add this after your existing product form -->
    <div class="mt-6 p-6 bg-white rounded-lg shadow-md">
        <h3 class="text-lg font-semibold mb-4">Product Images</h3>
        
        <form action="{{ route('admin.products.images.update', $product) }}" 
            method="POST" 
            enctype="multipart/form-data"
            class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Upload Images</label>
                <input type="file" 
                    name="images[]" 
                    multiple 
                    accept="image/*"
                    class="mt-1 block w-full">
            </div>
            <button type="submit" 
                    class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-700">
                Upload Images
            </button>
            </form>
        </div>
    </div>
</div>
@endsection
