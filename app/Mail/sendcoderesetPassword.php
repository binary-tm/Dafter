<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendcoderesetPassword extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    public $code;
    /**
     * Create a new message instance.
     */
    public function __construct( $email ,$code)
    {
        $this->email = $email;
        $this->code = $code;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Sendcodereset Password',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.sendcodeResetPssword',
        );
    }


    public function build()
    {
        return $this
            ->subject('Thank you for subscribing to our newsletter')
            ->markdown('emails.subscribers');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
