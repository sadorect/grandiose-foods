<?php

namespace App\Listeners;

use App\Models\LoginAttempt;
use Illuminate\Auth\Events\Failed;

class LogFailedLoginAttempt
{
    public function handle(Failed $event): void
    {
        LoginAttempt::create([
            'ip_address' => request()->ip(),
            'email' => request()->email,
            'user_agent' => request()->userAgent(),
            'status' => 'failed',
            'attempted_at' => now()
        ]);
    }
}
