@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto py-6">
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold">Active Sessions</h2>
        </div>

        <div class="p-6">
            @foreach($sessions as $session)
                <div class="flex items-center justify-between py-4 border-b last:border-0">
                    <div class="space-y-1">
                        <div class="flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                            <span class="font-medium">{{ $session->device }} - {{ $session->platform }}</span>
                        </div>
                        <div class="text-sm text-gray-500">
                            <p>IP: {{ $session->ip_address }}</p>
                            <p>Last active: {{ $session->last_active->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    @if(!$loop->first)
                        <form action="{{ route('admin.profile.sessions.terminate', $session->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-red-600 hover:text-red-800 text-sm font-medium">
                                Terminate
                            </button>
                        </form>
                    @else
                        <span class="text-sm text-gray-500">Current session</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
