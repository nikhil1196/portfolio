<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $rows = Reservation::with(['table'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('name', 'like', "%$q%") ->orWhere('phone', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('reservations.index', array_merge(compact('rows'), [
            'dining_tables' => \App\Models\DiningTable::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'table_id' => 'required|exists:tables,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'guests' => 'required|integer|min:1',
            'res_date' => 'required|date',
            'res_time' => 'required',
            'status' => 'required|in:Booked,Seated,Cancelled,No-show',
        ]);

        Reservation::create($data);
        return back()->with('ok', 'Table Reservation added.');
    }

    public function update(Request $request, Reservation $row)
    {
        $row->update($request->validate([
            'table_id' => 'required|exists:tables,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'guests' => 'required|integer|min:1',
            'res_date' => 'required|date',
            'res_time' => 'required',
            'status' => 'required|in:Booked,Seated,Cancelled,No-show',
        ]));
        return redirect()->route('reservations.index')->with('ok', 'Table Reservation updated.');
    }

    public function destroy(Reservation $row)
    {
        $row->delete();
        return back()->with('ok', 'Table Reservation deleted.');
    }
}
