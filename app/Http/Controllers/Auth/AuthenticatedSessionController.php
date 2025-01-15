<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Validate reCAPTCHA token
    $recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . config('services.recaptcha.secret_key') . '&response=' . $request->input('g-recaptcha-response'));
    $recaptcha = json_decode($recaptcha);
    
   /* Log::info('Login reCAPTCHA Validation:', [
        'success' => $recaptcha->success,
        'action' => $recaptcha->action,
        'timestamp' => $recaptcha->challenge_ts,
        'hostname' => $recaptcha->hostname
    ]);*/
        $request->authenticate();

        $request->session()->regenerate();

        if (auth()->user()->is_admin) {
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
