<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'max_attempts' => Cache::get('admin_login_max_attempts', 5),
            'decay_minutes' => Cache::get('admin_login_decay_minutes', 1),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function updateRateLimit(Request $request)
    {
        $validated = $request->validate([
            'max_attempts' => 'required|integer|min:1|max:10',
            'decay_minutes' => 'required|integer|min:1|max:60'
        ]);

        Cache::put('admin_login_max_attempts', $validated['max_attempts'], now()->addYear());
        Cache::put('admin_login_decay_minutes', $validated['decay_minutes'], now()->addYear());

        return back()->with('success', 'Rate limit settings updated successfully');
    }
}
