@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-lime-900">Create New Category</h1>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Name</label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       class="w-full border-gray-300 rounded-lg"
                       value="{{ old('name') }}"
                       required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                <textarea name="description" 
                          id="description" 
                          rows="4" 
                          class="w-full border-gray-300 rounded-lg"
                          required>{{ old('description') }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-lime-600 text-white px-6 py-2 rounded-lg hover:bg-lime-700">
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
