<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $allowedPerPage = [25, 50, 100];
        $perPage = (int) request()->integer('per_page', 25);

        if (! in_array($perPage, $allowedPerPage, true)) {
            $perPage = 25;
        }

        $users = User::latest()->paginate($perPage)->withQueryString();

        return view('admin.users.index', compact('users', 'perPage'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_admin'] = $request->boolean('is_admin');
        $validated['is_active'] = $request->boolean('is_active', true);
        
        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        $user->load('orders');
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_admin'] = $request->boolean('is_admin');
        $validated['is_active'] = $request->boolean('is_active');

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account');
        }

        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }

    public function massAction(Request $request)
    {
        $validated = $request->validate([
            'selected_users' => ['required', 'array', 'min:1'],
            'selected_users.*' => ['integer', 'exists:users,id'],
            'action' => ['required', 'in:delete,activate,deactivate'],
        ]);

        $selectedIds = collect($validated['selected_users'])
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        $currentUserId = (int) Auth::id();

        if ($validated['action'] === 'delete') {
            $safeIds = $selectedIds->reject(fn ($id) => $id === $currentUserId);

            if ($safeIds->isEmpty()) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'No users were deleted. You cannot delete your own account.');
            }

            User::whereIn('id', $safeIds)->delete();

            if ($safeIds->count() !== $selectedIds->count()) {
                return redirect()->route('admin.users.index')
                    ->with('success', 'Selected users deleted. Your account was skipped.');
            }

            return redirect()->route('admin.users.index')
                ->with('success', 'Selected users deleted.');
        }

        if ($validated['action'] === 'deactivate') {
            $safeIds = $selectedIds->reject(fn ($id) => $id === $currentUserId);

            if ($safeIds->isEmpty()) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'No users were deactivated. You cannot deactivate your own account.');
            }

            User::whereIn('id', $safeIds)->update(['is_active' => false]);

            if ($safeIds->count() !== $selectedIds->count()) {
                return redirect()->route('admin.users.index')
                    ->with('success', 'Selected users deactivated. Your account was skipped.');
            }

            return redirect()->route('admin.users.index')
                ->with('success', 'Selected users deactivated.');
        }

        User::whereIn('id', $selectedIds)->update(['is_active' => true]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Selected users activated.');
    }
}
