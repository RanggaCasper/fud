<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TokenEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $result;
    /**
     * Create a new message instance.
     */
    public function __construct($result)
    {
        $this->result = $result;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        $subject = $this->result['type'] == 'verify' ? 'Verify Your Email Address' : 'Reset Your Password';

        return $this->subject($subject)
                    ->view('mail.token')
                    ->with(['result' => $this->result]);
    }
}