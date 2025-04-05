<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session as FlashSession;


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

    public function confirmBooking($id)
{
    $session = \App\Models\Session::findOrFail($id);

    // Fire the real-time event
    event(new \App\Events\BookingConfirmed($session));

    // Flash session name to be used on frontend
    FlashSession::flash('confirmed_session_name', $session->name);

    // Redirect back to the sessions page
    return redirect('http://127.0.0.1:8000/sessions');
}
}
