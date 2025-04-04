<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;


class SessionController extends Controller
{
    public function index()
    {
        // Paginate sessions (10 per page)
        $sessions = Session::paginate(4);
        return view('sessions.index', compact('sessions'));
    }

    public function book($id)
    {
        // Simulate booking a session
        $session = Session::findOrFail($id);
        
        // Dispatch a queued job to send a booking confirmation
        dispatch(new \App\Jobs\SendBookingConfirmation($session));

        return response()->json([
            'message' => 'Booking request received. You will receive a confirmation email soon.',
            'session' => $session
        ]);
    }
}
