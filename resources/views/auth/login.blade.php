<x-guest-layout>
    <div class="bg-white p-8 rounded-lg shadow-md max-w-md mx-auto">
        <h2 class="text-2xl font-bold text-lime-900 mb-6 text-center">Login to Your Account</h2>
        
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <x-input-label for="email" value="Email" class="text-gray-700" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                    class="mt-1 block w-full rounded-md bg-yellow-50 border-gray-300 focus:border-lime-500 focus:ring-lime-500" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" value="Password" class="text-gray-700" />
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password"
                    class="mt-1 block w-full rounded-md bg-yellow-50 border-gray-300 focus:border-lime-500 focus:ring-lime-500" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-lime-600 focus:ring-lime-500">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-lime-600 hover:text-lime-700" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input type="hidden" name="g-recaptcha-response" id="recaptcha-token">
            <button type="submit" class="w-full bg-lime-600 text-white py-2 px-4 rounded-lg hover:bg-lime-700 transition">
                Log in
            </button>

            <p class="text-center text-sm text-gray-600">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-lime-600 hover:text-lime-700">Register here</a>
            </p>
        </form>
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
</x-guest-layout>
