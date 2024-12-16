<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Admin Login') }}
    </div>

    <form method="POST" action="{{ route('admin.access') }}" id="admin-login-form">
        @csrf
                   <!-- Add this styled notification div -->
                   <div id="rate-limit-error" class="mt-4 hidden">
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium" id="rate-limit-message"></p>
                            </div>
                        </div>
                    </div>
                </div>
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
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                const errorDiv = document.getElementById('rate-limit-error');
                document.getElementById('rate-limit-message').textContent = 
                    `${data.error} Please try again in ${Math.ceil(data.retry_after/60)} minutes.`;
                errorDiv.classList.remove('hidden');
                setTimeout(() => {
                    errorDiv.classList.add('hidden');
                }, 5000);
            } else {
                window.location.href = '{{ route('admin.dashboard') }}';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>

</x-guest-layout>
