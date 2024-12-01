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
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                            <span class="font-medium">{{ $session->user->name }}</span>
                            @if($loop->first)
                                <span class="ml-2 px-2 py-1 text-xs bg-lime-100 text-lime-800 rounded">Current</span>
                            @endif
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                            <div>
                                <p class="font-medium">Device Info</p>
                                <p>{{ $session->device }} ({{ $session->platform }})</p>
                                <p>{{ $session->getBrowser() }}</p>
                            </div>
                            <div>
                                <p class="font-medium">Location</p>
                                <p>IP: {{ $session->ip_address }}</p>
                                <p>{{ $session->location ?? 'Location unavailable' }}</p>
                            </div>
                            <div>
                                <p class="font-medium">Time Info</p>
                                <p>Started: {{ $session->created_at->format('M d, Y H:i') }}</p>
                                <p>Duration: {{ $session->created_at->diffForHumans($session->last_active, true) }}</p>
                            </div>
                            <div>
                                <p class="font-medium">Status</p>
                                <p>Last active: {{ $session->last_active->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if(!$loop->first)
                        <form action="{{ route('admin.profile.sessions.terminate', $session->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-red-600 hover:text-red-800 text-sm font-medium">
                                Terminate Session
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection