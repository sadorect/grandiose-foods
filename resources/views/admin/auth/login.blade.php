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

        <!-- reCAPTCHA -->
        <input type="hidden" name="g-recaptcha-response" id="recaptcha-token">

        <!-- Rate Limit Error Display -->
        <div id="rate-limit-error" class="mt-4 text-red-600 hidden"></div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <!-- reCAPTCHA and Rate Limit Handling -->
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'admin_login'})
                .then(function(token) {
                    document.getElementById('recaptcha-token').value = token;
                });
        });

        document.getElementById('admin-login-form').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            const errorDiv = document.getElementById('rate-limit-error');
            errorDiv.textContent = `${data.error} Please try again in ${Math.ceil(data.retry_after/60)} minutes.`;
            errorDiv.classList.remove('hidden');
        } else {
            window.location.href = '{{ route('admin.dashboard') }}';
        }
    })
    .catch(error => console.log('Error:', error));
});

    </script>
</x-guest-layout>
