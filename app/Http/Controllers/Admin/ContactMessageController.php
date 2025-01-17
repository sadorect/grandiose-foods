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
          $query->where('status', $request->status);
      }
      
      $messages = $query->paginate(20);
      
      return view('admin.contact-messages.index', compact('messages'));
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
        Mail::to($message->email)->send(new AdminReply($message, request('reply_content'), $message->name, $message->subject, request('original_message')));
        $message->update(['status' => ContactMessage::STATUS_REPLIED]);
        
        return redirect()->route('admin.contact-messages.show', $message)
            ->with('success', 'Reply sent successfully');
    }
}
