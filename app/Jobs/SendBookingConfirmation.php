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
        // Simulate email sending by logging the session details
        Log::info("Booking confirmation sent for session: " . $this->session->name);
        event(new BookingConfirmed($this->session));


    }
}
