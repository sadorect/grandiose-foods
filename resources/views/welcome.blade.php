<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Grandiose Foods - Wholesale Food Supplier</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-yellow-50">
    <!-- Navigation -->
    <nav class="bg-yellow-400 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-lime-800">Grandiose Foods</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-lime-900 hover:text-lime-700">Products</a>
                    <a href="#" class="text-lime-900 hover:text-lime-700">Categories</a>
                    <a href="#" class="text-lime-900 hover:text-lime-700">Bulk Orders</a>
                    <a href="#" class="text-lime-900 hover:text-lime-700">Contact</a>
                    <a href="#" class="bg-lime-600 text-white px-4 py-2 rounded-lg hover:bg-lime-700">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-yellow-300 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-lime-900 mb-4">Premium Wholesale Food Products</h1>
                <p class="text-xl text-lime-800 mb-8">Quality ingredients for your business needs</p>
                <a href="#" class="bg-lime-600 text-white px-8 py-3 rounded-lg hover:bg-lime-700">Browse Catalog</a>
            </div>
        </div>
    </div>

    <!-- Featured Categories -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-2xl font-bold text-lime-900 mb-8">Featured Categories</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition">
                <h3 class="text-xl font-semibold text-lime-800 mb-2">Grains & Cereals</h3>
                <p class="text-gray-600 mb-4">Premium quality wholesale grains</p>
                <a href="#" class="text-lime-600 hover:text-lime-700">View Products →</a>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition">
                <h3 class="text-xl font-semibold text-lime-800 mb-2">Dried Fruits</h3>
                <p class="text-gray-600 mb-4">Naturally dried premium fruits</p>
                <a href="#" class="text-lime-600 hover:text-lime-700">View Products →</a>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition">
                <h3 class="text-xl font-semibold text-lime-800 mb-2">Nuts & Seeds</h3>
                <p class="text-gray-600 mb-4">Fresh and high-quality nuts</p>
                <a href="#" class="text-lime-600 hover:text-lime-700">View Products →</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-yellow-400 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h4 class="text-lg font-semibold text-lime-900 mb-4">About Us</h4>
                    <p class="text-lime-800">Your trusted partner in wholesale food distribution</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-lime-900 mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-lime-800 hover:text-lime-700">Products</a></li>
                        <li><a href="#" class="text-lime-800 hover:text-lime-700">Bulk Orders</a></li>
                        <li><a href="#" class="text-lime-800 hover:text-lime-700">Shipping</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-lime-900 mb-4">Contact</h4>
                    <ul class="space-y-2">
                        <li class="text-lime-800">Phone: (555) 123-4567</li>
                        <li class="text-lime-800">Email: info@grandiosefoods.com</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-lime-900 mb-4">Newsletter</h4>
                    <input type="email" placeholder="Enter your email" class="w-full px-4 py-2 rounded-lg">
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
