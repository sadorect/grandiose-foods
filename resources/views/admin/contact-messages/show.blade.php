@extends('layouts.admin')

@section('title', 'Message Details')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Message Details</h2>
        <a href="{{ route('admin.contact-messages.index') }}" class="text-lime-700 hover:text-lime-800">
            ← Back to Messages
        </a>
    </div>
    
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600">From:</p>
                <p class="font-medium">{{ $message->name }} ({{ $message->email }})</p>
            </div>
            <div>
                <p class="text-gray-600">Subject:</p>
                <p class="font-medium">{{ $message->subject }}</p>
            </div>
            <div>
                <p class="text-gray-600">Received:</p>
                <p class="font-medium">{{ $message->created_at->format('F j, Y g:i a') }}</p>
            </div>
            <div>
                <p class="text-gray-600">Status:</p>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    {{ $message->status === 'unread' ? 'bg-yellow-100 text-yellow-900' : 
                       ($message->status === 'read' ? 'bg-blue-100 text-blue-800' : 
                        'bg-green-100 text-green-800') }}">
                    {{ ucfirst($message->status) }}
                </span>
            </div>
        </div>
    </div>

    <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">Message Content:</h3>
        <div class="bg-gray-50 rounded-lg p-4 whitespace-pre-wrap">
            {{ $message->content }}
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Reply to Message</h3>
        <form action="{{ route('admin.contact-messages.reply', $message->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <input type="hidden" name="original_message" value="{{ $message->content }}" />
                
                <textarea 
                    name="reply_content" 
                    rows="6" 
                    class="w-full rounded-lg border-gray-300 focus:border-lime-500 focus:ring focus:ring-lime-200 transition duration-200"
                    placeholder="Type your reply here..."
                    required
                ></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-lime-700 text-white px-6 py-2 rounded-lg hover:bg-lime-800 transition duration-200">
                    Send Reply
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
