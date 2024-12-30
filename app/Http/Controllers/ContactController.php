<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'g-recaptcha-response' => 'recaptcha',
        ]);

        // Send email
        Mail::to('info@grandiosefoods.com')->send(new ContactFormMail($validated));

        return back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }
}
