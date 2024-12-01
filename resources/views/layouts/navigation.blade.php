<nav class="bg-yellow-400 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo/Brand -->
            <div class="flex items-center">
                <a href="/" class="text-2xl font-bold text-lime-800">Grandiose Foods</a>
            </div>

            <!-- Main Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                @if(Route::has('products.index'))
                    <a href="{{ route('products.index') }}" 
                       class="text-lime-900 hover:text-lime-700 {{ request()->routeIs('products.*') ? 'font-bold' : '' }}">
                       Products
                    </a>
                @endif
                
                @if(Route::has('categories.index'))
                    <a href="{{ route('categories.index') }}" 
                       class="text-lime-900 hover:text-lime-700 {{ request()->routeIs('categories.*') ? 'font-bold' : '' }}">
                       Categories
                    </a>
                @endif

                <!-- Cart with Counter -->
                @if(Route::has('cart.index'))
                    <a href="{{ route('cart.index') }}" class="relative">
                        <span class="text-lime-900 hover:text-lime-700">Cart</span>
                        @if(isset($cartCount) && $cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-lime-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                @endif

                <!-- Authentication Links -->
                @auth
                    @if(Route::has('admin.dashboard'))
                        <a href="{{ route('admin.dashboard') }}" class="text-lime-900 hover:text-lime-700">Dashboard</a>
                    @endif
                    
                    @if(Route::has('admin.logout'))
                        <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-lime-900 hover:text-lime-700">Logout</button>
                        </form>
                    @endif
                @else
                    @if(Route::has('admin.login'))
                        <a href="{{ route('admin.login') }}" class="bg-lime-600 text-white px-4 py-2 rounded-lg hover:bg-lime-700">Login</a>
                    @endif
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button class="mobile-menu-button">
                    <svg class="w-6 h-6 text-lime-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu hidden md:hidden">
        @if(Route::has('products.index'))
            <a href="{{ route('products.index') }}" class="block py-2 px-4 text-lime-900 hover:bg-yellow-300">Products</a>
        @endif
        
        @if(Route::has('categories.index'))
            <a href="{{ route('categories.index') }}" class="block py-2 px-4 text-lime-900 hover:bg-yellow-300">Categories</a>
        @endif
        
        @if(Route::has('cart.index'))
            <a href="{{ route('cart.index') }}" class="block py-2 px-4 text-lime-900 hover:bg-yellow-300">Cart</a>
        @endif
        
        @auth
            @if(Route::has('dashboard'))
                <a href="{{ route('dashboard') }}" class="block py-2 px-4 text-lime-900 hover:bg-yellow-300">Dashboard</a>
            @endif
            
            @if(Route::has('logout'))
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 px-4 text-lime-900 hover:bg-yellow-300">Logout</button>
                </form>
            @endif
        @else
            @if(Route::has('admin.login'))
                <a href="{{ route('admin.login') }}" class="block py-2 px-4 text-lime-900 hover:bg-yellow-300">Login</a>
            @endif
        @endauth
    </div>
</nav>
