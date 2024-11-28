<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class AdminLoginRateLimiter
{
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'login.' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            
            return response()->json([
                'error' => 'Too many login attempts.',
                'retry_after' => $seconds
            ], 429);
        }

        RateLimiter::hit($key, 60);

        return $next($request);
    }
}
