<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'stats' => [
                'Events' => Event::where('status','Published')->count(),
                'Bookings' => Booking::where('status','Confirmed')->count(),
                'Seats Sold' => Booking::where('status','Confirmed')->sum('seats'),
                'Revenue' => '₹'.number_format(Booking::where('status','Confirmed')->sum('amount')),
            ],
            'rows'  => Event::where('event_date','>=',now())->orderBy('event_date')->limit(6)->get(),
        ]);
    }
}
