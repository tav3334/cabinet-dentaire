<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Appointment $appointment,
        public string $newStatus
    ) {}

    public function envelope(): Envelope
    {
        $statusLabels = [
            'confirmed' => 'confirmé',
            'canceled' => 'annulé',
            'pending' => 'en attente',
        ];

        return new Envelope(
            subject: 'Votre rendez-vous a été ' . ($statusLabels[$this->newStatus] ?? $this->newStatus) . ' - Cabinet Dentaire',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-status-changed',
        );
    }
}
