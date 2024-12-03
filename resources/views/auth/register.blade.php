<x-guest-layout>
    <div class="bg-white p-8 rounded-lg shadow-md max-w-md mx-auto">
        <h2 class="text-2xl font-bold text-lime-900 mb-6 text-center">Create Your Account</h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <div>
                <x-input-label for="name" value="Name" class="text-gray-700" />
                <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" 
                    class="mt-1 block w-full rounded-md bg-yellow-50 border-gray-300 focus:border-lime-500 focus:ring-lime-500" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" value="Email" class="text-gray-700" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" 
                    class="mt-1 block w-full rounded-md bg-yellow-50 border-gray-300 focus:border-lime-500 focus:ring-lime-500" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" value="Password" class="text-gray-700" />
                <x-text-input id="password" type="password" name="password" required autocomplete="new-password"
                    class="mt-1 block w-full rounded-md bg-yellow-50 border-gray-300 focus:border-lime-500 focus:ring-lime-500" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" value="Confirm Password" class="text-gray-700" />
                <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="mt-1 block w-full rounded-md bg-yellow-50 border-gray-300 focus:border-lime-500 focus:ring-lime-500" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <button type="submit" class="w-full bg-lime-600 text-white py-2 px-4 rounded-lg hover:bg-lime-700 transition">
                Register
            </button>

            <p class="text-center text-sm text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-lime-600 hover:text-lime-700">Login here</a>
            </p>
        </form>
    </div>
</x-guest-layout>
