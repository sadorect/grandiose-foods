<?php

namespace App\Traits;

use App\Models\AdminActivityLog;

trait LogsAdminActivity
{
    public function logActivity($action, $details = null)
    {
        AdminActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'details' => $details
        ]);
    }
}
