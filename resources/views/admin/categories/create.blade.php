@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')
<div class="bg-white rounded-lg shadow-md">
    <form action="{{ route('admin.categories.store') }}" method="POST" class="p-6">
        @csrf
<meta name="csrf-token" content="{{ csrf_token() }}">

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
            <input type="text" 
                   name="name" 
                   id="name" 
                   class="w-full border-gray-300 rounded-lg bg-yellow-300 @error('name') border-red-500 @enderror focus:border-lime-600"
                   value="{{ old('name') }}"
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
                      class="w-full border-gray-300 rounded-lg bg-yellow-300 focus:border-lime-600 @error('description') border-red-500 @enderror"
                      required>{{ old('description') }}</textarea>
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
                Create Category
            </button>
        </div>
    </form>
</div>
@endsection