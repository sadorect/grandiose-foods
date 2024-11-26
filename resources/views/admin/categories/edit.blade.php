@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-lime-900">Edit Category: {{ $category->name }}</h1>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Name</label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       class="w-full border-gray-300 rounded-lg"
                       value="{{ old('name', $category->name) }}"
                       required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                <textarea name="description" 
                          id="description" 
                          rows="4" 
                          class="w-full border-gray-300 rounded-lg"
                          required>{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('categories.index') }}" 
                   class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                    Cancel
                </a>
                <button type="submit" class="bg-lime-600 text-white px-6 py-2 rounded-lg hover:bg-lime-700">
                    Update Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
