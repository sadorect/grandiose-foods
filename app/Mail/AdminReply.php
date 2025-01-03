<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class AdminReply extends Mailable
{
    public $message;
    public $replyContent;
    public $name;
    public $subject;
    
    public function __construct($message, $replyContent, $name, $subject)
    {
        $this->message = $message;
        $this->replyContent = $replyContent;
        $this->name = $name;
        $this->subject = $subject;
    }
    
    public function build()
    {
        return $this->from('support@grandiosefoods.com')
                    ->subject("Re: {$this->message->subject}")
                    ->view('emails.admin-reply')->with(['message' => $this->message,
                    'replyContent' => $this->replyContent,
                'name' => $this->name, 'subject' => $this->subject]);
    }
}
