<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $this->checkTooManyFailedAttempts();

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
           // 'recaptcha_token' => 'required'
        ]);

        //$this->validateReCaptcha($credentials['recaptcha_token']);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            if (Auth::user()->is_admin) {
                RateLimiter::clear($this->throttleKey());
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }
            
            Auth::logout();
            $this->incrementFailedAttempts();
            throw ValidationException::withMessages([
                'email' => 'You do not have admin access.',
            ]);
        }

        $this->incrementFailedAttempts();
        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    private function validateReCaptcha($token)
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $token,
        ]);

        if (!$response->successful() || !$response->json('success')) {
            throw ValidationException::withMessages([
                'recaptcha' => 'Invalid reCAPTCHA verification.',
            ]);
        }
    }

    private function throttleKey()
    {
        return request()->ip();
    }

    private function checkTooManyFailedAttempts()
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            throw ValidationException::withMessages([
                'email' => 'Too many login attempts. Please try again later.',
            ]);
        }
    }

    private function incrementFailedAttempts()
    {
        RateLimiter::hit($this->throttleKey(), 60);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
