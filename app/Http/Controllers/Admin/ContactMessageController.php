<?php

namespace App\Http\Controllers\Admin;

use App\Mail\AdminReply;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::latest();

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', (int) $request->status);
        }

        $messages = $query->paginate(20)->withQueryString();

        return view('admin.contact-messages.index', compact('messages'));
    }

    public function massAction(Request $request)
    {
        $validated = $request->validate([
            'selected_messages' => ['required', 'array', 'min:1'],
            'selected_messages.*' => ['integer', 'exists:contact_messages,id'],
            'action' => ['required', 'in:mark_unread,mark_read,mark_replied,delete'],
        ]);

        $selectedIds = collect($validated['selected_messages'])
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();

        if ($validated['action'] === 'delete') {
            ContactMessage::whereIn('id', $selectedIds)->delete();

            return redirect()->route('admin.contact-messages.index')
                ->with('success', 'Selected messages deleted.');
        }

        $status = match ($validated['action']) {
            'mark_unread' => ContactMessage::STATUS_UNREAD,
            'mark_read' => ContactMessage::STATUS_READ,
            default => ContactMessage::STATUS_REPLIED,
        };

        ContactMessage::whereIn('id', $selectedIds)->update(['status' => $status]);

        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Selected messages updated.');
    }
  
    
    public function show(int $id)
    {
        $message = ContactMessage::findOrFail($id);
        
        if ($message->status === ContactMessage::STATUS_UNREAD) {
            $message->update(['status' => ContactMessage::STATUS_READ]);
        }
        return view('admin.contact-messages.show', compact('message'));
    }

    
    public function reply(ContactMessage $message)
    {
        Mail::to($message->email)->queue(new AdminReply($message, request('reply_content'), $message->name, $message->subject, request('original_message')));
        $message->update(['status' => ContactMessage::STATUS_REPLIED]);
        
        return redirect()->route('admin.contact-messages.show', $message)
            ->with('success', 'Reply sent successfully');
    }
}
