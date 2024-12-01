@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-3xl mx-auto py-6">
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold">Profile Settings</h2>
        </div>

        <form action="{{ route('admin.profile') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PATCH')

            <div class="flex items-center space-x-6">
                <div class="shrink-0">
                    <img class="h-16 w-16 object-cover rounded-full" 
                         src="{{ $user->avatar ? Storage::url($user->avatar) : asset('images/default-avatar.png') }}" 
                         alt="{{ $user->name }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Photo</label>
                    <input type="file" name="avatar" class="mt-1 block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-lime-50 file:text-lime-700
                        hover:file:bg-lime-100">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                         <input type="text" 
                                name="name" 
                                value="{{ old('name', $user->name) }}" 
                                class="mt-1 block w-full rounded-md bg-yellow-200 border-gray-300 focus:border-lime-500 focus:ring focus:ring-lime-200 focus:ring-opacity-50">
                     </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                       class="mt-1 block w-full  bg-yellow-200 rounded-md border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" 
                       class="mt-1 block w-full  bg-yellow-200 rounded-md border-gray-300">
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="email_notifications" value="1" 
                       {{ $user->email_notifications ? 'checked' : '' }}
                       class="rounded border-gray-300 text-lime-600">
                <label class="ml-2 text-sm text-gray-700">Receive email notifications</label>
            </div>

            <div class="flex justify-end">
                <button type="submit" 
                        class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-700">
                    Save Changes
                </button>
            </div>
        </form>
    </div>



<div class="mt-10 bg-white rounded-lg shadow-md">
  <div class="p-6 border-b">
      <h2 class="text-xl font-semibold">Change Password</h2>
  </div>

  <form action="{{ route('admin.profile.password') }}" method="POST" class="p-6 space-y-6">
      @csrf
      @method('PUT')

      <div>
          <label class="block text-sm font-medium text-gray-700">Current Password</label>
          <input type="password" name="current_password" 
                 class="mt-1 block w-full  bg-yellow-200 rounded-md border-gray-300">
      </div>

      <div>
          <label class="block text-sm font-medium text-gray-700">New Password</label>
          <input type="password" name="password" 
                 class="mt-1 block w-full bg-yellow-200 rounded-md border-gray-300">
      </div>

      <div>
          <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
          <input type="password" name="password_confirmation" 
                 class="mt-1 block w-full  bg-yellow-200 rounded-md border-gray-300">
      </div>

      <div class="flex justify-end">
          <button type="submit" 
                  class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-700">
              Update Password
          </button>
      </div>
  </form>
</div>

<!-- Activity Log -->

<div class="mt-10 bg-white rounded-lg shadow-md">
    <div class="p-6 border-b">
        <h2 class="text-xl font-semibold">Recent Activity</h2>
    </div>

    <div class="p-6">
        @if($activities->count())
            <div class="space-y-4">
                @foreach($activities as $activity)
                    <div class="flex items-center justify-between py-3 border-b last:border-0">
                        <div>
                            <p class="text-gray-700">{{ ucfirst($activity->action) }}</p>
                            <p class="text-sm text-gray-500">
                                IP: {{ $activity->ip_address }}
                            </p>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $activity->created_at->diffForHumans() }}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No recent activity</p>
        @endif
    </div>
</div>
<!-- End of Activity Log -->

<div class="mt-4 flex justify-end space-x-4">
  <a href="{{ route('admin.profile.sessions') }}" 
     class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-200">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
      </svg>
      Manage Sessions
  </a>
</div>

</div>



@endsection