<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use Illuminate\Http\Request;

class ParkingController extends Controller
{
    public function index()
    {
        $rows = Parking::with(['unit'])->latest();
        $rows = $rows->paginate(15)->withQueryString();
        return view('parking.index', array_merge(compact('rows'), [
            'units' => \App\Models\Unit::orderBy('flat_no')->pluck('flat_no', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slot_no' => 'required|string|max:20',
            'unit_id' => 'nullable|exists:units,id',
            'vehicle_no' => 'nullable|string',
            'vehicle_type' => 'required|in:Car,Bike,Scooter,Other',
            'status' => 'required|in:Assigned,Free,Blocked',
        ]);

        Parking::create($data);
        return back()->with('ok', 'Parking Slot added.');
    }

    public function update(Request $request, Parking $row)
    {
        $row->update($request->validate([
            'slot_no' => 'required|string|max:20',
            'unit_id' => 'nullable|exists:units,id',
            'vehicle_no' => 'nullable|string',
            'vehicle_type' => 'required|in:Car,Bike,Scooter,Other',
            'status' => 'required|in:Assigned,Free,Blocked',
        ]));
        return redirect()->route('parking.index')->with('ok', 'Parking Slot updated.');
    }

    public function destroy(Parking $row)
    {
        $row->delete();
        return back()->with('ok', 'Parking Slot deleted.');
    }
}
