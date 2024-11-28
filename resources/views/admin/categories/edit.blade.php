@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="bg-white rounded-lg shadow-md">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
            <input type="text" 
                   name="name" 
                   id="name" 
                   class="w-full border-gray-300 rounded-lg @error('name') border-red-500 @enderror"
                   value="{{ old('name', $category->name) }}"
                   required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" 
                      id="description" 
                      rows="4" 
                      class="w-full border-gray-300 rounded-lg @error('description') border-red-500 @enderror"
                      required>{{ old('description', $category->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.categories.index') }}" 
               class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                Cancel
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-lime-600 text-white rounded-lg hover:bg-lime-700">
                Update Category
            </button>
        </div>
    </form>
</div>
@endsection