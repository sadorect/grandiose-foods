<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    protected $fillable = [
        'ip_address',
        'email',
        'user_agent',
        'status',
        'attempted_at'
    ];
}
