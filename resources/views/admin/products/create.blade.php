@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold">Create New Product</h2>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" 
                           class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                    @error('sku')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="4" 
                          class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Base Price</label>
                    <input type="number" step="0.01" name="base_price" value="{{ old('base_price') }}"
                           class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                    @error('base_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Minimum Order Quantity</label>
                    <input type="number" name="min_order_quantity" value="{{ old('min_order_quantity', 1) }}"
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
                        <option value="weight">Weight</option>
                        <option value="volume">Volume</option>
                    </select>
                    @error('measurement_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Stock Quantity</label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity') }}"
                           class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                    @error('stock_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Variants</label>
                <div class="space-y-2">
                    <div class="grid grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Package Size</label>
                            <input type="number" name="variants[0][size]" placeholder="e.g. 25" 
                                   class="rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
                            <input type="text" name="variants[0][unit]" placeholder="e.g. kg" 
                                   class="rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                            <input type="number" step="0.01" name="variants[0][price]" placeholder="e.g. 99.99" 
                                   class="rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                            <input type="number" name="variants[0][stock]" placeholder="e.g. 100" 
                                   class="rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500">
                        </div>
                    </div>
                </div>
                @error('variants')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            

            <div>
                <label class="block text-sm font-medium text-gray-700">Specifications</label>
                <textarea name="specifications" rows="3" 
                          class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500"
                          placeholder='{
                "Origin": "Nigeria",
                "Grade": "Premium A",
                "Processing": "Natural",
                "Quality": "Export Grade",
                "Storage": "Keep in cool, dry place"
            }'
                >{{ old('specifications') }}</textarea>
                @error('specifications')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            

            <div>
                <label class="block text-sm font-medium text-gray-700">Product Image</label>
                <input type="file" name="image" class="mt-1 block w-full">
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-700">
                    Create Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection