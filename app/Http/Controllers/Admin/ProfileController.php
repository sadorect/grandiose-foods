<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\AdminActivityLog;
use App\Traits\LogsAdminActivity;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use LogsAdminActivity;

    public function edit()
    {
        $user = auth()->user();
        $activities = AdminActivityLog::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        return view('admin.profile.edit', [
            'user' => $user,
            'activities' => $activities
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'max:1024'],
            'email_notifications' => ['boolean'],
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $user->update($validated);
        
        $this->logActivity('profile_updated', [
            'updated_fields' => array_keys($validated)
        ]);

        return back()->with('success', 'Profile updated successfully');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, auth()->user()->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['password'])
        ]);

        $this->logActivity('password_changed');

        return back()->with('success', 'Password changed successfully');
    }
}
