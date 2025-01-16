<div class="bg-lime-800 w-64 px-4 py-6">
    <div class="mb-8">
        <h1 class="text-white text-2xl font-bold">Admin Panel</h1>
    </div>
    
    <nav class="space-y-2">
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center text-white py-2.5 px-4 rounded hover:bg-lime-700 {{ request()->routeIs('admin.dashboard') ? 'bg-lime-700' : '' }}">
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.hero-slides.index') }}" class="flex items-center text-white py-2.5 px-4 rounded hover:bg-lime-700 {{ request()->routeIs('admin.hero-slides.*') ? 'bg-lime-700' : '' }}">
    <span>Hero Slides</span>
    </a>

        <a href="{{ route('admin.categories.index') }}" 
           class="flex items-center text-white py-2.5 px-4 rounded hover:bg-lime-700 {{ request()->routeIs('admin.categories.*') ? 'bg-lime-700' : '' }}">
            <span>Categories</span>
        </a>
        <a href="{{ route('admin.products.index') }}" 
           class="flex items-center text-white py-2.5 px-4 rounded hover:bg-lime-700 {{ request()->routeIs('admin.products.*') ? 'bg-lime-700' : '' }}">
            <span>Products</span>
        </a>
        <a href="{{ route('admin.orders.index') }}" 
           class="flex items-center text-white py-2.5 px-4 rounded hover:bg-lime-700 {{ request()->routeIs('admin.orders.*') ? 'bg-lime-700' : '' }}">
            <span>Orders</span>
        </a>
        <a href="{{ route('admin.users.index') }}" 
           class="flex items-center text-white py-2.5 px-4 rounded hover:bg-lime-700 {{ request()->routeIs('admin.users.*') ? 'bg-lime-700' : '' }}">
            <span>Users</span>
        </a>
        <a href="{{ route('admin.contact-messages.index') }}" 
           class="flex items-center justify-between text-white py-2.5 px-4 rounded hover:bg-lime-700 {{ request()->routeIs('admin.contact-messages.*') ? 'bg-lime-700' : '' }}">
            <span>Messages</span>
            @php
                $unreadCount = \App\Models\ContactMessage::where('status', 0)->count();
            @endphp
            @if($unreadCount > 0)
                <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                    {{ $unreadCount }}
                </span>
            @endif
        </a>
        <a href="{{ route('admin.settings') }}" 
           class="flex items-center text-white py-2.5 px-4 rounded hover:bg-lime-700 {{ request()->routeIs('admin.settings') ? 'bg-lime-700' : '' }}">
            <span>Settings</span>
        </a>
    </nav>
</div>
