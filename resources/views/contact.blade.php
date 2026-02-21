@extends('layouts.app')

@section('title', 'Contact Us - Grandiose Foods')

@section('content')

<!-- Contact Header -->
<div class="relative bg-lime-900 py-16">
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ asset('images/contact-header.jpg') }}" 
             alt="Contact Us" 
             class="w-full h-full object-cover opacity-20">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Get in Touch</h1>
        <p class="text-xl text-white/90">We're here to help with all your wholesale food needs</p>
    </div>
</div>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- Contact Information -->
        <div>
            <h2 class="text-2xl font-bold text-lime-900 mb-6">Get in Touch</h2>
            <div class="space-y-6">
                <div class="flex items-start space-x-4">
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-lime-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lime-900">Address</h3>
                        <p class="text-gray-600">7900 Harford Rd, Parkville<br>MD, 21234, United States</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-lime-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lime-900">Email</h3>
                        <p class="text-gray-600">info@grandiosefoods.com</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-lime-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lime-900">Phone</h3>
                        <p class="text-gray-600">+1 443 290 4982</p>
                    </div>
                </div>
            </div>
<!-- Google Maps Section -->
            <div class="mt-8 mb-8 h-96 rounded-lg overflow-hidden shadow-lg">
                <iframe
                    width="100%"
                    height="100%"
                    frameborder="0"
                    style="border:0"
                    src="https://www.google.com/maps/embed/v1/place?key={{ config('services.google.maps_key') }}&q=7900+Harford+Rd,+Parkville,+MD+21234"
                    allowfullscreen>
                </iframe>
            </div>
        </div>



        <!-- Contact Form -->
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-lime-900 mb-6">Send us a Message</h2>
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                    <input type="text" name="name" id="name" 
                    class="w-full p-3 border-gray-300 rounded-lg bg-yellow-200 focus:border-lime-600 @error('name') border-red-500 @enderror" 
                    value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" name="email" id="email" 
                           class="w-full p-3 border-gray-300 rounded-lg bg-yellow-200 focus:border-lime-600 @error('email') border-red-500 @enderror" 
                           value="{{ old('email') }}" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subject" class="block text-gray-700 font-medium mb-2">Subject</label>
                    <input type="text" name="subject" id="subject" 
                           class="w-full p-3 border-gray-300 rounded-lg bg-yellow-200 focus:border-lime-600 @error('subject') border-red-500 @enderror" 
                           value="{{ old('subject') }}" required>
                    @error('subject')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="message" class="block text-gray-700 font-medium mb-2">Message</label>
                    <textarea name="message" id="message" rows="4" 
                              class="w-full p-3 border-gray-300 rounded-lg bg-yellow-200 focus:border-lime-600 @error('message') border-red-500 @enderror" 
                              required>{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                   
                    @error('g-recaptcha-response')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full px-4 py-3 bg-lime-700 text-white rounded-lg hover:bg-lime-800 transition">
                    Send Message
                </button>
            </form>
        </div>
    </div>
</div>
 <!-- reCAPTCHA v3 script -->
 <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
 <script>
     grecaptcha.ready(function() {
         grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'login'})
             .then(function(token) {
                 document.getElementById('recaptcha-token').value = token;
             });
     });
 </script>
@endsection
