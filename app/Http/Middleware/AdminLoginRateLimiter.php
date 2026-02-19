<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class AdminLoginRateLimiter
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->isMethod('post')) {
            return $next($request);
        }

        $key = 'admin.login.'.strtolower($request->input('email', '')).'|'.$request->ip();
        $maxAttempts = Cache::get('admin_login_max_attempts', 5);
        
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);

            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Too many login attempts.',
                    'retry_after' => $seconds,
                ], 429);
            }

            throw ValidationException::withMessages([
                'email' => ["Too many login attempts. Try again in {$seconds} seconds."],
            ]);
        }

        return $next($request);
    }

}
