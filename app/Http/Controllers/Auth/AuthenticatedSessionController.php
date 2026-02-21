<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Support\MathCaptcha;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        return view('auth.login', [
            'mathCaptchaQuestion' => MathCaptcha::generate($request, 'user_login'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->validate([
            'math_captcha_answer' => ['required', 'integer'],
        ]);

        if (! MathCaptcha::validate($request, 'user_login', (string) $request->input('math_captcha_answer'))) {
            throw ValidationException::withMessages([
                'math_captcha_answer' => 'Incorrect captcha answer. Please try again.',
            ]);
        }

        $request->authenticate();

        if (! Auth::user()->is_active) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => 'Your account is deactivated. Please contact support.',
            ]);
        }

        $request->session()->regenerate();

        if (Auth::user()->is_admin) {
            return redirect()->intended(route('admin.dashboard'));
        }
        
        
        return redirect()->intended(route('products.index'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
