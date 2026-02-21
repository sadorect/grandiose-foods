<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\MathCaptcha;
use App\Mail\ContactFormMail;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show(Request $request)
    {
        return view('contact', [
            'mathCaptchaQuestion' => MathCaptcha::generate($request, 'contact_form'),
        ]);
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'math_captcha_answer' => ['required', 'integer'],
        ]);

        if (! MathCaptcha::validate($request, 'contact_form', (string) $request->input('math_captcha_answer'))) {
            return back()
                ->withErrors(['math_captcha_answer' => 'Incorrect captcha answer. Please try again.'])
                ->withInput();
        }

        $validated['content'] = $validated['message'];
        ContactMessage::create($validated);
        // Send email
        Mail::to('info@grandiosefoods.com')->queue(new ContactFormMail($validated));

        return back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }
}
