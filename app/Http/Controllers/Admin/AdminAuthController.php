<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminSession;
use App\Support\MathCaptcha;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    public function showLoginForm(Request $request)
    {
        return view('admin.auth.login', [
            'mathCaptchaQuestion' => MathCaptcha::generate($request, 'admin_login'),
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'math_captcha_answer' => ['required', 'integer'],
        ]);

        if (! MathCaptcha::validate($request, 'admin_login', (string) $request->input('math_captcha_answer'))) {
            throw ValidationException::withMessages([
                'math_captcha_answer' => 'Incorrect captcha answer. Please try again.',
            ]);
        }

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            if (! Auth::user()->is_active) {
                Auth::logout();
                $this->incrementFailedAttempts($request);

                throw ValidationException::withMessages([
                    'email' => 'Your account is deactivated. Please contact support.',
                ]);
            }

            if (Auth::user()->is_admin) {
                RateLimiter::clear($this->throttleKey($request));
                $request->session()->regenerate();

                return redirect()->intended(route('admin.dashboard'));
            }

            Auth::logout();
            $this->incrementFailedAttempts($request);

            throw ValidationException::withMessages([
                'email' => 'You do not have admin access.',
            ]);
        }

        $this->incrementFailedAttempts($request);

        throw ValidationException::withMessages([
            'email' => 'Invalid credentials.',
        ]);
    }

    private function throttleKey(Request $request): string
    {
        return 'admin.login.'.strtolower($request->input('email', '')).'|'.$request->ip();
    }

    private function incrementFailedAttempts(Request $request): void
    {
        $decayMinutes = (int) Cache::get('admin_login_decay_minutes', 1);
        RateLimiter::hit($this->throttleKey($request), $decayMinutes * 60);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
