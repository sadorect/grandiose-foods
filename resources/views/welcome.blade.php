@extends('layouts.app')

@section('title', 'Premium Wholesale Food Products')
@section('meta_description', 'Grandiose Foods offers premium wholesale food products including grains, dried fruits, and nuts for businesses. Get quality ingredients at competitive prices.')

@section('content')
    <!-- Hero Section -->
    <!-- Hero Section -->
    <section class="relative bg-yellow-300 hero-section">
        @foreach($heroSlides as $slide)
            <div class="hero-slide h-[600px] {{ !$loop->first ? 'hidden' : '' }}">
                <div class="absolute inset-0 bg-center bg-cover" style="background-image: url('{{ Storage::url($slide->image_path) }}')">
                    <div class="absolute inset-0 bg-black/40"></div>
                    <div class="relative h-full flex items-center justify-center text-center">
                        <div class="text-white">
                            <h1 class="text-5xl md:text-6xl font-bold mb-4">{{ $slide->title }}</h1>
                            <p class="text-xl md:text-2xl mb-8">{{ $slide->subtitle }}</p>
                            <a href="{{ $slide->button_link }}" class="bg-lime-700 text-white px-8 py-4 rounded-lg hover:bg-lime-800 transition-colors text-lg">
                                {{ $slide->button_text }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>


    <!-- Featured Categories -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-2xl font-bold text-lime-900 mb-8">Featured Categories</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition">
                    <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                    <h3 class="text-xl font-semibold text-lime-800 mb-2">{{ $category->name }}</h3>
                    <p class="text-gray-600 mb-4">{{ $category->description }}</p>
                    <a href="{{route('categories.show', $category->slug)}}" class="text-lime-700 hover:text-lime-800">View Products →</a>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="bg-yellow-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-lime-900 mb-8 text-center">Why Choose Grandiose Foods</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="bg-white p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-lime-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lime-900">Quality Assured</h3>
                </div>
                <div class="text-center">
                    <div class="bg-white p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-lime-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lime-900">Fast Delivery</h3>
                </div>
                <div class="text-center">
                    <div class="bg-white p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-lime-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lime-900">Competitive Prices</h3>
                </div>
                <div class="text-center">
                    <div class="bg-white p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-lime-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lime-900">Dedicated Support</h3>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
    <script src="{{ asset('js/hero-slider.js') }}"></script>
@endpush

@endsection
