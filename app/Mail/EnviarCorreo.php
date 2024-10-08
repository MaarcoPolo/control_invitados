<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnviarCorreo extends Mailable
{
    use Queueable, SerializesModels;

    public $invitado;
    public $evento;
    public $pdf;
    public $hora;
    public $f;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invitado,$evento,$pdf,$hora,$f)
    {
        $this->invitado = $invitado;
        $this->evento = $evento;
        $this->pdf = $pdf;
        $this->hora = $hora;
        $this->f = $f;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->evento->nombre,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.enviar_correo',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [
            Attachment::fromData(fn () => $this->pdf, 'Invitacion.pdf')
                ->withMime('application/pdf'),
        ];
    }
}