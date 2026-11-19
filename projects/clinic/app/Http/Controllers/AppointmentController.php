<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $rows = Appointment::with(['patient','doctor'])->latest()->get();
        return view('appointments.index', array_merge(compact('rows'), [
            'patients' => \App\Models\Patient::orderBy('name')->pluck('name', 'id'),
            'doctors' => \App\Models\Doctor::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appt_date' => 'required|date',
            'appt_time' => 'nullable',
            'reason' => 'nullable|string',
            'status' => 'required|in:Scheduled,Completed,Cancelled',
        ]);

        Appointment::create($data);
        return back()->with('ok', 'Appointment added.');
    }

    public function update(Request $request, Appointment $row)
    {
        $row->update($request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appt_date' => 'required|date',
            'appt_time' => 'nullable',
            'reason' => 'nullable|string',
            'status' => 'required|in:Scheduled,Completed,Cancelled',
        ]));
        return redirect()->route('appointments.index')->with('ok', 'Appointment updated.');
    }

    public function destroy(Appointment $row)
    {
        $row->delete();
        return back()->with('ok', 'Appointment deleted.');
    }
}
