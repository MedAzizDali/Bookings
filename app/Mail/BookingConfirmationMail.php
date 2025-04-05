<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Session;

class BookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function build()
    {
        return $this->subject('Booking Confirmed for ' . $this->session->name)
                    ->view('emails.booking_confirmation');
    }
}

