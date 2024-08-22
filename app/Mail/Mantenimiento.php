<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Mantenimiento extends Mailable
{
    use Queueable, SerializesModels;
    public $control;
    public $domicilio;
    /**
     * Create a new message instance.
     */
    public function __construct($control, $domicilio)
    {
        $this->control = $control;
        $this->domicilio = $domicilio;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'PRUEBA NUEVA APP',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        return new Content(
            view: 'mails.mantenimiento',
        );
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
