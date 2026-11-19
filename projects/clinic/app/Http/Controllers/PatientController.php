<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $rows = Patient::latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->where('name', 'like', "%$q%")->orWhere('phone', 'like', "%$q%")->orWhere('email', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('patients.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string',
            'blood' => 'nullable|string|max:5',
            'address' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
            'medical_history' => 'nullable|string', 'document' => 'nullable|file|max:4096',
        ]);
        if ($request->hasFile('document')) { $data['document'] = $request->file('document')->store('docs', 'public'); }

        Patient::create($data);
        return back()->with('ok', 'Patient added.');
    }

    public function update(Request $request, Patient $row)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string',
            'blood' => 'nullable|string|max:5',
            'address' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
            'medical_history' => 'nullable|string', 'document' => 'nullable|file|max:4096',
        ]);
        if ($request->hasFile('document')) { $data['document'] = $request->file('document')->store('docs', 'public'); }
        $row->update($data);
        return redirect()->route('patients.index')->with('ok', 'Patient updated.');
    }

    public function destroy(Patient $row)
    {
        $row->delete();
        return back()->with('ok', 'Patient deleted.');
    }
}
