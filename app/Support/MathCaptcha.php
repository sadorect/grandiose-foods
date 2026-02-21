<?php

namespace App\Support;

use Illuminate\Http\Request;

class MathCaptcha
{
    public static function generate(Request $request, string $context): string
    {
        $left = random_int(1, 9);
        $right = random_int(1, 9);

        $request->session()->put(self::sessionKey($context), self::hashAnswer($left + $right));

        return "{$left} + {$right}";
    }

    public static function validate(Request $request, string $context, string $answer): bool
    {
        $expectedHash = (string) $request->session()->pull(self::sessionKey($context), '');

        if ($expectedHash === '' || $answer === '') {
            return false;
        }

        return hash_equals($expectedHash, self::hashAnswer((int) $answer));
    }

    private static function sessionKey(string $context): string
    {
        return "math_captcha.{$context}";
    }

    private static function hashAnswer(int $answer): string
    {
        return hash_hmac('sha256', (string) $answer, (string) config('app.key'));
    }
}
