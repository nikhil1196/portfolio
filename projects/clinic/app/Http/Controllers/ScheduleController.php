<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $rows = Schedule::with(['doctor','clinic'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('day', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('schedules.index', array_merge(compact('rows'), [
            'doctors' => \App\Models\Doctor::orderBy('name')->pluck('name', 'id'),
            'clinics' => \App\Models\Clinic::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'clinic_id' => 'nullable|exists:clinics,id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required',
            'end_time' => 'required',
            'slot_min' => 'nullable|integer|min:5',
            'status' => 'required|in:Active,Inactive',
        ]);

        Schedule::create($data);
        return back()->with('ok', 'Doctor Schedule added.');
    }

    public function update(Request $request, Schedule $row)
    {
        $row->update($request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'clinic_id' => 'nullable|exists:clinics,id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required',
            'end_time' => 'required',
            'slot_min' => 'nullable|integer|min:5',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('schedules.index')->with('ok', 'Doctor Schedule updated.');
    }

    public function destroy(Schedule $row)
    {
        $row->delete();
        return back()->with('ok', 'Doctor Schedule deleted.');
    }
}
