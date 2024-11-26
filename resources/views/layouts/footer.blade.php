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
                    @if(Route::has('products.index'))
                        <li><a href="{{ route('products.index') }}" class="text-lime-800 hover:text-lime-700">Products</a></li>
                    @endif
                    @if(Route::has('contact'))
                        <li><a href="{{ route('contact') }}" class="text-lime-800 hover:text-lime-700">Contact</a></li>
                    @endif
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
        
        <div class="mt-8 pt-8 border-t border-lime-600">
            <p class="text-center text-lime-800">© {{ date('Y') }} Grandiose Foods. All rights reserved.</p>
        </div>
    </div>
</footer>
