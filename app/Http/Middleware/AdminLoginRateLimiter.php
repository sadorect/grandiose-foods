<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class AdminLoginRateLimiter
{
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'login.' . $request->ip();
        $maxAttempts = Cache::get('admin_login_max_attempts', 5);
        $decayMinutes = Cache::get('admin_login_decay_minutes', 1);
        
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            
            return response()->json([
                'error' => 'Too many login attempts.',
                'retry_after' => $seconds
            ], 429);
        }

        RateLimiter::hit($key, $decayMinutes * 60);

        return $next($request);
    }

}
