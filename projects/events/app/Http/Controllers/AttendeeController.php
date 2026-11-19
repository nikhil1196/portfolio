<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    public function index()
    {
        $rows = Attendee::with(['booking.event'])->latest()->get();
        return view('attendees.index', array_merge(compact('rows'), [
            'bookings' => \App\Models\Booking::orderBy('booking_no')->pluck('booking_no', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'name' => 'required|string|max:255',
            'checked_in' => 'nullable|boolean',
        ]);

        Attendee::create($data);
        return back()->with('ok', 'Attendee added.');
    }

    public function update(Request $request, Attendee $row)
    {
        $row->update($request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'name' => 'required|string|max:255',
            'checked_in' => 'nullable|boolean',
        ]));
        return redirect()->route('attendees.index')->with('ok', 'Attendee updated.');
    }

    public function destroy(Attendee $row)
    {
        $row->delete();
        return back()->with('ok', 'Attendee deleted.');
    }

    public function checkin(Attendee $row)
    {
        $row->update(["checked_in" => !$row->checked_in]);
        return back()->with("ok", $row->checked_in ? "Checked in." : "Check-in removed.");
    }
}