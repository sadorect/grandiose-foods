@extends('layouts.admin')

@section('title', 'Admin Settings')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800 mb-6">Rate Limiting Settings</h2>

            <form action="{{ route('admin.settings.rate-limit') }}" method="POST" id="settings-form">
                @csrf
                <input type="hidden" name="g-recaptcha-response" id="recaptcha-token">
                
                <div class="grid grid-cols-1 gap-6 max-w-xl">
                    <div>
                        <x-input-label for="max_attempts" value="Maximum Login Attempts" class="font-semibold text-gray-800" />
                        <x-text-input id="max_attempts" 
                                     type="number" 
                                     name="max_attempts" 
                                     class="mt-1 block w-full" 
                                     value="{{ $settings['max_attempts'] }}"
                                     min="1"
                                     max="10" />
                        <x-input-error :messages="$errors->get('max_attempts')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="decay_minutes" value="Lockout Duration (minutes)" class="font-semibold text-gray-800" />
                        <x-text-input id="decay_minutes" 
                                     type="number" 
                                     name="decay_minutes" 
                                     class="mt-1 block w-full" 
                                     value="{{ $settings['decay_minutes'] }}"
                                     min="1"
                                     max="60" />
                        <x-input-error :messages="$errors->get('decay_minutes')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
                        <x-primary-button>Save Settings</x-primary-button>
                    </div>
                </div>
            </form>
            <!-- Add this right after the form -->
<div id="security-alert" class="fixed top-4 right-4 transform transition-transform duration-300 translate-x-full">
  <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded shadow-lg">
      <div class="flex items-center">
          <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
              </svg>
          </div>
          <div class="ml-3">
              <p class="text-sm font-medium" id="security-message"></p>
          </div>
      </div>
  </div>
</div>

        </div>
    </div>
</div>

<!-- reCAPTCHA script -->
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
<script>
    document.getElementById('settings-form').addEventListener('submit', function(e) {
    e.preventDefault();
    grecaptcha.ready(function() {
        grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'settings_update'})
            .then(function(token) {
                document.getElementById('recaptcha-token').value = token;
                return fetch('{{ route('admin.settings.rate-limit') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: new FormData(document.getElementById('settings-form'))
                });
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    throw new Error(data.message);
                }
                window.location.reload();
            })
            .catch(error => {
                const alert = document.getElementById('security-alert');
                document.getElementById('security-message').textContent = error.message || 'Security verification failed. Please try again.';
                alert.classList.remove('translate-x-full');
                setTimeout(() => {
                    alert.classList.add('translate-x-full');
                }, 3000);
            });
    });
});

</script>
@endsection
