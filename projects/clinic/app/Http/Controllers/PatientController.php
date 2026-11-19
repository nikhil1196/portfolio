<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $rows = Patient::latest()->get();
        return view('patients.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string',
            'blood' => 'nullable|string|max:5',
            'address' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        Patient::create($data);
        return back()->with('ok', 'Patient added.');
    }

    public function update(Request $request, Patient $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string',
            'blood' => 'nullable|string|max:5',
            'address' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('patients.index')->with('ok', 'Patient updated.');
    }

    public function destroy(Patient $row)
    {
        $row->delete();
        return back()->with('ok', 'Patient deleted.');
    }
}
