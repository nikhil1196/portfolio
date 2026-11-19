<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $rows = Booking::with(['unit'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('amenity', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('bookings.index', array_merge(compact('rows'), [
            'units' => \App\Models\Unit::orderBy('flat_no')->pluck('flat_no', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'amenity' => 'required|in:Clubhouse,Community Hall,Swimming Pool,Tennis Court,Party Lawn',
            'unit_id' => 'required|exists:units,id',
            'booking_date' => 'required|date',
            'slot' => 'nullable|string',
            'status' => 'required|in:Confirmed,Cancelled,Completed',
        ]);

        Booking::create($data);
        return back()->with('ok', 'Amenity Booking added.');
    }

    public function update(Request $request, Booking $row)
    {
        $row->update($request->validate([
            'amenity' => 'required|in:Clubhouse,Community Hall,Swimming Pool,Tennis Court,Party Lawn',
            'unit_id' => 'required|exists:units,id',
            'booking_date' => 'required|date',
            'slot' => 'nullable|string',
            'status' => 'required|in:Confirmed,Cancelled,Completed',
        ]));
        return redirect()->route('bookings.index')->with('ok', 'Amenity Booking updated.');
    }

    public function destroy(Booking $row)
    {
        $row->delete();
        return back()->with('ok', 'Amenity Booking deleted.');
    }
}
