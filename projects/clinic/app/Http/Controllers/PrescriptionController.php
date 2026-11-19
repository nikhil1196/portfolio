<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index()
    {
        $rows = Prescription::with(['patient','doctor'])->latest()->get();
        return view('prescriptions.index', array_merge(compact('rows'), [
            'patients' => \App\Models\Patient::orderBy('name')->pluck('name', 'id'),
            'doctors' => \App\Models\Doctor::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'notes' => 'nullable|string',
            'medicines' => 'nullable|string',
        ]);

        Prescription::create($data);
        return back()->with('ok', 'Prescription added.');
    }

    public function update(Request $request, Prescription $row)
    {
        $row->update($request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'notes' => 'nullable|string',
            'medicines' => 'nullable|string',
        ]));
        return redirect()->route('prescriptions.index')->with('ok', 'Prescription updated.');
    }

    public function destroy(Prescription $row)
    {
        $row->delete();
        return back()->with('ok', 'Prescription deleted.');
    }
}
