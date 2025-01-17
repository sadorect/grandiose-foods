<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class AdminReply extends Mailable
{
    public $message;
    public $replyContent;
    public $name;
    public $subject;
    public  $originalMessage;
    
    public function __construct($message, $replyContent, $name, $subject, $originalMessage)
    {
        $this->message = $message;
        $this->replyContent = $replyContent;
        $this->name = $name;
        $this->subject = $subject;
        $this->originalMessage = $originalMessage;
    }
    
    public function build()
    {
        return $this->from('support@grandiosefoods.com')
                    ->subject("Re: {$this->message->subject}")
                    ->view('emails.admin-reply')->with(['message' => $this->message->message,
                    'replyContent' => $this->replyContent,
                'name' => $this->name, 'subject' => $this->subject, 'originalMessage' => $this->originalMessage]);
    }
}
