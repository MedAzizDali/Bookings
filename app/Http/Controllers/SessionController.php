<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use Illuminate\Support\Facades\Redirect;
use App\Jobs\SendBookingConfirmation;
use App\Events\BookingConfirmed;


class SessionController extends Controller
{
    public function index()
    {
        
        $sessions = Session::paginate(4);
        return view('sessions.index', compact('sessions'));
    }

    public function book($id)
    {
        
        $session = Session::findOrFail($id);
        
        
        dispatch(new SendBookingConfirmation($session));

        return response()->json([
            'message' => 'Booking request received. You will receive a confirmation email soon.',
            'session' => $session
        ]);
    }

    public function confirmBooking($id)
    {
        $session = Session::findOrFail($id);

        
        event(new BookingConfirmed($session));


        return redirect('http://127.0.0.1:8000/sessions');
    }
}
