@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Contact Messages</h2>
        <div class="filters">
          <select name="status" onchange="filterMessages(this.value)" 
          class="rounded-lg border-gray-300 focus:border-lime-500 focus:ring focus:ring-lime-200">
      <option value="">All Status</option>
      <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Unread</option>
      <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Read</option>
      <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>Replied</option>
  </select>
  
        </div>
    </div>

    <form id="bulk-message-action-form" action="{{ route('admin.contact-messages.mass-action') }}" method="POST" class="mb-4 flex flex-wrap items-center gap-3">
        @csrf
        <select name="action" class="rounded-md border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500" required>
            <option value="">Bulk Action</option>
            <option value="mark_unread">Mark as Unread</option>
            <option value="mark_read">Mark as Read</option>
            <option value="mark_replied">Mark as Replied</option>
            <option value="delete">Delete</option>
        </select>
        <button type="submit" class="bg-lime-700 text-white px-4 py-2 rounded-lg hover:bg-lime-800" onclick="return confirm('Apply this action to selected messages?')">
            Apply
        </button>
        @error('action')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
        @error('selected_messages')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <input id="select-all-messages" type="checkbox" class="rounded border-gray-300 text-lime-700 shadow-sm focus:border-lime-500 focus:ring-lime-500">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">From</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Received</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($messages as $message)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input form="bulk-message-action-form" name="selected_messages[]" value="{{ $message->id }}" type="checkbox" class="message-select-checkbox rounded border-gray-300 text-lime-700 shadow-sm focus:border-lime-500 focus:ring-lime-500">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusLabel = match ((int) $message->status) {
                                    0 => 'Unread',
                                    1 => 'Read',
                                    default => 'Replied',
                                };

                                $statusClass = match ((int) $message->status) {
                                    0 => 'bg-yellow-100 text-yellow-900',
                                    1 => 'bg-blue-100 text-blue-800',
                                    default => 'bg-green-100 text-green-800',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $message->name }}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 truncate max-w-xs">{{ $message->subject }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $message->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $message->created_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.contact-messages.show', $message->id) }}" 
                               class="text-lime-700 hover:text-lime-800 font-medium">
                                View Details →
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $messages->links() }}
    </div>
</div>

<script>
  function filterMessages(status) {
    window.location.href = "{{ route('admin.contact-messages.index') }}?status=" + status;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('select-all-messages');
        const checkboxes = document.querySelectorAll('.message-select-checkbox');

        if (!selectAll) {
            return;
        }

        selectAll.addEventListener('change', function () {
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = selectAll.checked;
            });
        });
    });
</script>
@endsection
