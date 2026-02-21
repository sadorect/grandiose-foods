<x-guest-layout>
    <div class="bg-white p-8 rounded-lg shadow-md max-w-md mx-auto">
        <h2 class="text-2xl font-bold text-lime-900 mb-6 text-center">Reset Password</h2>
        
        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.
        </div>

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <div>
                <x-input-label for="email" value="Email" class="text-gray-700" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                    class="mt-1 block w-full rounded-md bg-yellow-50 border-gray-300 focus:border-lime-500 focus:ring-lime-500" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="math_captcha_answer" :value="'Solve: '.$mathCaptchaQuestion" class="text-gray-700" />
                <x-text-input id="math_captcha_answer" type="number" name="math_captcha_answer" required
                    class="mt-1 block w-full rounded-md bg-yellow-50 border-gray-300 focus:border-lime-500 focus:ring-lime-500" />
                <x-input-error :messages="$errors->get('math_captcha_answer')" class="mt-2" />
            </div>

            <button type="submit" class="w-full bg-lime-700 text-white py-2 px-4 rounded-lg hover:bg-lime-800 transition">
                Email Password Reset Link
            </button>

            <p class="text-center text-sm text-gray-600">
                <a href="{{ route('login') }}" class="text-lime-700 hover:text-lime-800">
                    Back to login
                </a>
            </p>
        </form>
    </div>
</x-guest-layout>
