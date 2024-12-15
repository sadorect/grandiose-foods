<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Wholesale Food Supplier') | Grandiose Foods</title>
    <meta name="description" content="@yield('meta_description', 'Premium wholesale food products for businesses. Quality grains, dried fruits, nuts and more at competitive prices.')">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', 'Grandiose Foods - Wholesale Food Supplier')">
    <meta property="og:description" content="@yield('og_description', 'Premium wholesale food products for businesses')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'Grandiose Foods - Wholesale Food Supplier')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Premium wholesale food products for businesses')">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Structured Data -->
    @yield('structured_data')
</head>
<body class="bg-yellow-50">
    @include('layouts.navigation')
    
    <main>
        @yield('content')
    </main>

    @include('layouts.footer')
    <!-- Schema.org Organization Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Grandiose Foods",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/logo.png') }}",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+1-555-123-4567",
            "contactType": "customer service"
        }
    }
    </script>
</body>
</html>
