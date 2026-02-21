@extends('layouts.admin')

@section('title', 'Categories Management')

@section('content')
<div class="bg-white rounded-lg shadow-md">
    <div class="p-6 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800">All Categories</h3>
        <a href="{{ route('admin.categories.create') }}" class="bg-lime-700 text-white px-4 py-2 rounded-lg hover:bg-lime-800">
            Add New Category
        </a>
    </div>

    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($categories as $category)
                <tr>
                    <td class="px-6 py-4">
                        <img src="{{ $category->image }}"
     alt="{{ $category->name }}"
     class="h-16 w-16 object-cover rounded-lg">

                    </td>
                    <td class="px-6 py-4">{{ $category->name }}</td>
                    <td class="px-6 py-4">{{ $category->products_count }}</td>
                    <td class="px-6 py-4 flex space-x-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" 
                           class="text-lime-700 hover:text-lime-800">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" 
                                    onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
