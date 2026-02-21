@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="p-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Users</h2>
        <div class="flex items-center gap-3">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center gap-2">
                <label for="per_page" class="text-sm text-gray-600">Show</label>
                <select id="per_page" name="per_page" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500">
                    <option value="25" @selected(($perPage ?? 25) === 25)>25</option>
                    <option value="50" @selected(($perPage ?? 25) === 50)>50</option>
                    <option value="100" @selected(($perPage ?? 25) === 100)>100</option>
                </select>
                <span class="text-sm text-gray-600">per page</span>
            </form>

            <a href="{{ route('admin.users.create') }}" class="bg-lime-700 text-white px-4 py-2 rounded-lg hover:bg-lime-800">
                Add New User
            </a>
        </div>
    </div>

    <form id="bulk-user-action-form" action="{{ route('admin.users.mass-action') }}" method="POST" class="px-6 pb-4 flex flex-wrap items-center gap-3">
        @csrf
        <select name="action" class="rounded-md border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500" required>
            <option value="">Bulk Action</option>
            <option value="activate">Activate</option>
            <option value="deactivate">Deactivate</option>
            <option value="delete">Delete</option>
        </select>
        <button type="submit" class="bg-lime-700 text-white px-4 py-2 rounded-lg hover:bg-lime-800" onclick="return confirm('Apply this action to selected users?')">
            Apply
        </button>
        @error('action')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
        @error('selected_users')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </form>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <input id="select-all-users" type="checkbox" class="rounded border-gray-300 text-lime-700 shadow-sm focus:border-lime-500 focus:ring-lime-500">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input form="bulk-user-action-form" name="selected_users[]" value="{{ $user->id }}" type="checkbox" class="user-select-checkbox rounded border-gray-300 text-lime-700 shadow-sm focus:border-lime-500 focus:ring-lime-500">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_admin ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $user->is_admin ? 'Admin' : 'User' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-700' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-lime-700 hover:text-lime-900">Edit</a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this user?')">
                                    Delete
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center gap-2">
            <label for="per_page_bottom" class="text-sm text-gray-600">Show</label>
            <select id="per_page_bottom" name="per_page" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500">
                <option value="25" @selected(($perPage ?? 25) === 25)>25</option>
                <option value="50" @selected(($perPage ?? 25) === 50)>50</option>
                <option value="100" @selected(($perPage ?? 25) === 100)>100</option>
            </select>
            <span class="text-sm text-gray-600">per page</span>
        </form>

        <div>
            {{ $users->links() }}
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('select-all-users');
        const checkboxes = document.querySelectorAll('.user-select-checkbox');

        if (!selectAll) return;

        selectAll.addEventListener('change', function () {
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = selectAll.checked;
            });
        });
    });
</script>
@endsection
