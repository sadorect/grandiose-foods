<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        // Basic admin check
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        // reCAPTCHA verification for sensitive operations
        if ($this->requiresRecaptcha($request)) {
            $recaptchaResponse = $this->verifyRecaptcha($request);
            
            if (!$recaptchaResponse->success || $recaptchaResponse->score < 0.5) {
                Log::warning('Failed admin action reCAPTCHA:', [
                    'user' => auth()->user()->email,
                    'action' => $request->method(),
                    'score' => $recaptchaResponse->score ?? 'N/A'
                ]);
                
                return response()->json([
                    'error' => 'Security verification failed',
                    'message' => 'Please try again'
                ], 403);
            }

            Log::info('Successful admin action reCAPTCHA:', [
                'user' => auth()->user()->email,
                'action' => $request->method(),
                'score' => $recaptchaResponse->score
            ]);
        }

        return $next($request);
    }

    private function requiresRecaptcha(Request $request): bool
    {
        //$sensitiveActions = ['POST', 'PUT', 'PATCH', 'DELETE'];
        //return in_array($request->method(), $sensitiveActions);
        return $request->is('admin/login') && $request->isMethod('POST');
    }

    private function verifyRecaptcha(Request $request)
    {
        $recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?' . http_build_query([
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip()
        ]));

        return json_decode($recaptcha);
    }
}
