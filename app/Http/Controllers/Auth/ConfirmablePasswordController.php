<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\MathCaptcha;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     */
    public function show(Request $request): View
    {
        return view('auth.confirm-password', [
            'mathCaptchaQuestion' => MathCaptcha::generate($request, 'user_confirm_password'),
        ]);
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'math_captcha_answer' => ['required', 'integer'],
        ]);

        if (! MathCaptcha::validate($request, 'user_confirm_password', (string) $request->input('math_captcha_answer'))) {
            throw ValidationException::withMessages([
                'math_captcha_answer' => 'Incorrect captcha answer. Please try again.',
            ]);
        }

        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
