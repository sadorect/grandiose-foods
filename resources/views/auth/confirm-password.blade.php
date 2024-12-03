<x-guest-layout>
    <div class="bg-white p-8 rounded-lg shadow-md max-w-md mx-auto">
        <h2 class="text-2xl font-bold text-lime-900 mb-6 text-center">Confirm Password</h2>

        <div class="mb-4 text-sm text-gray-600">
            This is a secure area of the application. Please confirm your password before continuing.
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
            @csrf

            <div>
                <x-input-label for="password" value="Password" class="text-gray-700" />
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password"
                    class="mt-1 block w-full rounded-md bg-yellow-50 border-gray-300 focus:border-lime-500 focus:ring-lime-500" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <button type="submit" class="w-full bg-lime-600 text-white py-2 px-4 rounded-lg hover:bg-lime-700 transition">
                Confirm
            </button>
        </form>
    </div>
</x-guest-layout>
