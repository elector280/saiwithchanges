<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\SubscribeEmail;

class NewsletterWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $unsubscribeUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(public SubscribeEmail $subscriber)
    {
        // unsubscribe link (route name: newsletter.unsubscribe)
        $this->unsubscribeUrl = route('newsletter.unsubscribe', $this->subscriber->unsubscribe_token);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thanks for subscribing!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.newsletter_welcome',
            with: [
                'email' => $this->subscriber->email,
                'unsubscribeUrl' => $this->unsubscribeUrl,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
