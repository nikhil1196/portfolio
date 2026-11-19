<?php

namespace App\Http\Controllers;

use App\Models\ClassBooking;
use Illuminate\Http\Request;

class ClassBookingController extends Controller
{
    public function index()
    {
        $rows = ClassBooking::with(['gymClass','member'])->latest()->paginate(15)->withQueryString();
        return view('class-bookings.index', array_merge(compact('rows'), [
            'gym_classs' => \App\Models\GymClass::orderBy('name')->pluck('name', 'id'),
            'members' => \App\Models\Member::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'gym_class_id' => 'required|exists:gym_classes,id',
            'member_id' => 'required|exists:members,id',
            'booking_date' => 'required|date',
            'status' => 'required|in:Booked,Attended,Cancelled,No Show',
        ]);

        ClassBooking::create($data);
        return back()->with('ok', 'Class Booking added.');
    }

    public function update(Request $request, ClassBooking $row)
    {
        $row->update($request->validate([
            'gym_class_id' => 'required|exists:gym_classes,id',
            'member_id' => 'required|exists:members,id',
            'booking_date' => 'required|date',
            'status' => 'required|in:Booked,Attended,Cancelled,No Show',
        ]));
        return redirect()->route('class-bookings.index')->with('ok', 'Class Booking updated.');
    }

    public function destroy(ClassBooking $row)
    {
        $row->delete();
        return back()->with('ok', 'Class Booking deleted.');
    }
}
