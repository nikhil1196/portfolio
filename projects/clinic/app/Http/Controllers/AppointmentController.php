<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $rows = Appointment::with(['patient','doctor','clinic'])->latest()->get();
        return view('appointments.index', array_merge(compact('rows'), [
            'patients' => \App\Models\Patient::orderBy('name')->pluck('name', 'id'),
            'doctors' => \App\Models\Doctor::orderBy('name')->pluck('name', 'id'),
            'clinics' => \App\Models\Clinic::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'clinic_id' => 'nullable|exists:clinics,id',
            'appt_date' => 'required|date',
            'appt_time' => 'nullable',
            'reason' => 'nullable|string',
            'status' => 'required|in:Scheduled,Completed,Cancelled',
        ]);

        
        $doctor = \App\Models\Doctor::find($data['doctor_id']);
        if ($doctor) {
            $day = \Carbon\Carbon::parse($data['appt_date'])->format('l');
            $sched = \App\Models\Schedule::where('doctor_id', $doctor->id)
                ->where('day', $day)->where('status', 'Active')->first();
            if ($sched && $data['appt_time']) {
                $t = \Carbon\Carbon::parse($data['appt_time'])->format('H:i');
                if ($t < substr($sched->start_time, 0, 5) || $t >= substr($sched->end_time, 0, 5)) {
                    return back()->withInput()->with('error', "Dr. {$doctor->name} is available {$sched->start_time}–{$sched->end_time} on {$day}s.");
                }
            }
            $conflict = Appointment::where('doctor_id', $doctor->id)
                ->where('appt_date', $data['appt_date'])
                ->where('appt_time', $data['appt_time'])
                ->where('status', '!=', 'Cancelled')->exists();
            if ($conflict && $data['appt_time']) {
                return back()->withInput()->with('error', 'slot conflict: that time is already booked for this doctor.');
            }
        }

        Appointment::create($data);
        return back()->with('ok', 'Appointment added.');
    }

    public function update(Request $request, Appointment $row)
    {
        $row->update($request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'clinic_id' => 'nullable|exists:clinics,id',
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
