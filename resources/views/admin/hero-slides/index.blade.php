@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Hero Slides</h2>
        <a href="{{ route('admin.hero-slides.create') }}" 
           class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-700">
            Add New Slide
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left">Order</th>
                        <th class="px-6 py-3 text-left">Image</th>
                        <th class="px-6 py-3 text-left">Title</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($slides as $slide)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $slide->order }}</td>
                        <td class="px-6 py-4">
                            <img src="{{ Storage::url($slide->image_path) }}" 
                                 alt="{{ $slide->title }}"
                                 class="h-20 w-32 object-cover rounded">
                        </td>
                        <td class="px-6 py-4">{{ $slide->title }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $slide->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $slide->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.hero-slides.edit', $slide) }}" 
                               class="text-lime-600 hover:text-lime-700 mr-3">Edit</a>
                            <form action="{{ route('admin.hero-slides.destroy', $slide) }}" 
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
        </div>
    </div>
</div>
@endsection
