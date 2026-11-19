<?php
namespace App\Http\Controllers;
use App\Models\Booking;
class ETicketController extends Controller
{
    public function show(Booking $booking)
    {
        return view('eticket', ['b' => $booking->load('event', 'attendees', 'ticket')]);
    }
    public function markPaid(Booking $booking)
    {
        $booking->update(['payment' => 'Paid', 'txn_ref' => $booking->txn_ref ?? 'txn_' . strtoupper(\Illuminate\Support\Str::random(8))]);
        return back()->with('ok', 'Payment marked paid.');
    }
}