@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Products</h2>
        <div class="flex space-x-4">
            <a href="{{ route('admin.products.export') }}" 
               class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-700">
                Export Products
            </a>
            
            <button onclick="document.getElementById('importForm').classList.toggle('hidden')"
                    class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-700">
                Import Products
            </button>
            
            <a href="{{ route('admin.products.create') }}" 
               class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-700">
                Add New Product
            </a>
        </div>
    </div>

    <div id="importForm" class="hidden mb-6 p-4 bg-white rounded-lg shadow">
        <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex items-center space-x-4">
                <input type="file" name="file" accept=".xlsx,.csv" required
                       class="border rounded-md p-2">
                <button type="submit" 
                        class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-700">
                    Upload
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
            <!-- Search and Filter Form -->
            <form action="{{ route('admin.products.index') }}" method="GET" class="mb-4">
                <div class="flex space-x-4 items-center">
                    <select name="category" class="rounded-md bg-yellow-50 border-gray-300 focus:border-lime-500" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <select name="status" class="rounded-md bg-yellow-50 border-gray-300 focus:border-lime-500" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="1" @selected(request('status') == '1')>Active</option>
                        <option value="0" @selected(request('status') == '0')>Inactive</option>
                    </select>

                    <div class="flex items-center ml-auto">
                        <input type="search" 
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search products..." 
                               class="rounded-md bg-yellow-50 border-gray-300 focus:border-lime-500">
                        <button type="submit" class="ml-2 bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-700">
                            Search
                        </button>
                    </div>
                </div>
            </form>

            <!-- Mass Action Form -->
            <form id="mass-action-form" action="{{ route('admin.products.mass-action') }}" method="POST" class="mb-4">
                @csrf
                <div class="flex space-x-4">
                    <select name="action" class="rounded-md bg-yellow-50 border-gray-300 focus:border-lime-500">
                        <option value="">Select Action</option>
                        <option value="delete">Delete Selected</option>
                        <option value="deactivate">Deactivate Selected</option>
                        <option value="activate">Activate Selected</option>
                    </select>
                    <button type="submit" class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-700">
                        Apply
                    </button>
                </div>
            </form>

            <!-- Products Table -->
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300">
                        </th>
                        <th class="px-6 py-3 text-left">Product</th>
                        <th class="px-6 py-3 text-left">Category</th>
                        <th class="px-6 py-3 text-left">SKU</th>
                        <th class="px-6 py-3 text-right">Price</th>
                        <th class="px-6 py-3 text-center">Stock</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <input type="checkbox" form="mass-action-form" name="selected_products[]" value="{{ $product->id }}" class="product-checkbox rounded border-gray-300">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <img src="{{ $product->images->first() ? Storage::url($product->images->first()->path) : asset('images/placeholder.jpg') }}" 
     alt="{{ $product->name }}"
     class="h-10 w-10 object-cover rounded-lg">
                                <span>{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">{{ $product->category->name }}</td>
                        <td class="px-6 py-4">{{ $product->sku }}</td>
                        <td class="px-6 py-4 text-right">${{ number_format($product->base_price, 2) }}</td>
                        <td class="px-6 py-4 text-center">{{ $product->stock_quantity }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 text-xs rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.products.edit', $product) }}" 
                               class="text-lime-600 hover:text-lime-700 mr-3">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" 
                                  method="POST" 
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-700"
                                        onclick="return confirm('Are you sure?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.getElementsByClassName('product-checkbox');
        Array.from(checkboxes).forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
@endpush
@endsection
