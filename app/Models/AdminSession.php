<?php

namespace App\Models;

use App\Models\User;
use Jenssegers\Agent\Agent;
use Illuminate\Database\Eloquent\Model;

class AdminSession extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'device',
        'platform',
        'location',
        'last_active'
    ];

    protected $casts = [
        'last_active' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createFromRequest($request)
    {
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());

        return static::create([
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device' => $agent->device(),
            'platform' => $agent->platform(),
            'last_active' => now(),
        ]);
    }
}
