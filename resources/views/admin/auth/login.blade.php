<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Admin Login') }}
    </div>

    <form method="POST" action="{{ route('admin.access') }}" id="admin-login-form">
        @csrf
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="math_captcha_answer" :value="'Solve: '.$mathCaptchaQuestion" />
            <x-text-input id="math_captcha_answer" class="block mt-1 w-full" type="number" name="math_captcha_answer" required />
            <x-input-error :messages="$errors->get('math_captcha_answer')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>
