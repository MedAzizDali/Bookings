<?php

namespace App\Jobs;

use App\Models\Session;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Events\BookingConfirmed;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmationMail;

class SendBookingConfirmation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function handle()
    {
        Mail::to('azizdali248@gmail.com')->send(new BookingConfirmationMail($this->session));

        Log::info("Booking confirmation sent for session: " . $this->session->name);
       

    }
}
