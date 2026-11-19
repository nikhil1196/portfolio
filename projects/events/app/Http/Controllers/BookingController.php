<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $rows = Booking::with(['event'])->latest()->get();
        return view('bookings.index', array_merge(compact('rows'), [
            'events' => \App\Models\Event::orderBy('title')->pluck('title', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'seats' => 'required|integer|min:1',
            'amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:Confirmed,Cancelled,Refunded',
        ]);
        $data['booking_no'] = 'BKG-' . str_pad((string)(\App\Models\Booking::max('id') + 5001), 4, '0', STR_PAD_LEFT);
        Booking::create($data);
        return back()->with('ok', 'Booking added.');
    }

    public function update(Request $request, Booking $row)
    {
        $row->update($request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'seats' => 'required|integer|min:1',
            'amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:Confirmed,Cancelled,Refunded',
        ]));
        return redirect()->route('bookings.index')->with('ok', 'Booking updated.');
    }

    public function destroy(Booking $row)
    {
        $row->delete();
        return back()->with('ok', 'Booking deleted.');
    }
}
