@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold">Edit Hero Slide</h2>
        </div>

        <form action="{{ route('admin.hero-slides.update', $slide) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" value="{{ old('title', $slide->title) }}" 
                       class="mt-1 block w-full rounded-md bg-yellow-50 border-gray-300 focus:border-lime-500">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $slide->subtitle) }}" 
                       class="mt-1 block w-full rounded-md bg-yellow-50 border-gray-300 focus:border-lime-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Current Image</label>
                <img src="{{ Storage::url($slide->image_path) }}" 
                     alt="{{ $slide->title }}"
                     class="mt-2 h-40 object-cover rounded">
                
                <label class="block text-sm font-medium text-gray-700 mt-4">Change Image</label>
                <input type="file" name="image" accept="image/*" 
                       class="mt-1 block w-full">
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Button Text</label>
                    <input type="text" name="button_text" value="{{ old('button_text', $slide->button_text) }}" 
                           class="mt-1 block w-full rounded-md bg-yellow-50 border-gray-300 focus:border-lime-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Button Link</label>
                    <input type="text" name="button_link" value="{{ old('button_link', $slide->button_link) }}" 
                           class="mt-1 block w-full rounded-md bg-yellow-50 border-gray-300 focus:border-lime-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Order</label>
                    <input type="number" name="order" value="{{ old('order', $slide->order) }}" 
                           class="mt-1 block w-full rounded-md bg-yellow-50 border-gray-300 focus:border-lime-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="is_active" class="mt-1 block w-full rounded-md bg-yellow-50 border-gray-300 focus:border-lime-500">
                        <option value="1" @selected(old('is_active', $slide->is_active))>Active</option>
                        <option value="0" @selected(!old('is_active', $slide->is_active))>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.hero-slides.index') }}" 
                   class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-lime-600 text-white rounded-md hover:bg-lime-700">
                    Update Slide
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
