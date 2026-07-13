<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Notifies the portfolio owner when a visitor submits the contact form.
 */
class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array{name: string, email: string, subject: ?string, message: string}  $payload
     */
    public function __construct(public array $payload)
    {
    }

    public function envelope(): Envelope
    {
        $subject = filled($this->payload['subject'] ?? null)
            ? (string) $this->payload['subject']
            : 'New portfolio contact message';

        return new Envelope(
            subject: $subject,
            replyTo: [
                new Address($this->payload['email'], $this->payload['name']),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact-form',
            with: [
                'name' => $this->payload['name'],
                'email' => $this->payload['email'],
                'subject' => $this->payload['subject'] ?? null,
                'body' => $this->payload['message'],
            ],
        );
    }
}
