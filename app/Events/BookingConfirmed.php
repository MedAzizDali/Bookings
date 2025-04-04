<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Session;


class BookingConfirmed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sessionData;

    public function __construct(Session $session)
    {
        
        $this->sessionData = [
            'id' => $session->id,
            'name' => $session->name,
        ];
    }

    public function broadcastOn()
    {
        return new Channel('sessions');
    }

    public function broadcastAs()
    {
        return 'booking-confirmed';
    }

    public function broadcastWith()
    {
        return [
            'session' => $this->sessionData
        ];
    }


}
