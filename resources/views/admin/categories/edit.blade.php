@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="bg-white rounded-lg shadow-md">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="p-6" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
            <input type="text" 
                   name="name" 
                   id="name" 
                   class="w-full border-gray-300 rounded-lg bg-yellow-300 @error('name') border-red-500 @enderror focus:border-lime-600"
                   value="{{ old('name', $category->name) }}"
                   required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="image" class="block text-gray-700 font-medium mb-2">Category Image</label>
            <input type="file" 
                   name="image" 
                   id="image" 
                   class="w-full border-gray-300 rounded-lg @error('image') border-red-500 @enderror"
                   accept="image/*"
                   onchange="previewImage(this)">
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <div id="imagePreview" class="mt-4">
                <img src="{{ $category->image }}" alt="Category Image" class="max-w-xs rounded-lg shadow-md">
            </div>
        </div>

        <div class="mb-6">
            <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" 
                      id="description" 
                      rows="4" 
                      class="w-full border-gray-300 rounded-lg bg-yellow-300 focus:border-lime-600 @error('description') border-red-500 @enderror"
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
@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = preview.querySelector('img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
