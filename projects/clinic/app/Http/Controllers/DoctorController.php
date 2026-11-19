<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $rows = Doctor::latest()->get();
        return view('doctors.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'fee' => 'nullable|numeric|min:0',
            'status' => 'required|in:Active,Inactive',
        ]);

        Doctor::create($data);
        return back()->with('ok', 'Doctor added.');
    }

    public function update(Request $request, Doctor $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'fee' => 'nullable|numeric|min:0',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('doctors.index')->with('ok', 'Doctor updated.');
    }

    public function destroy(Doctor $row)
    {
        $row->delete();
        return back()->with('ok', 'Doctor deleted.');
    }
}
