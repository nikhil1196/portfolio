<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $rows = Doctor::with(['clinic'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('name', 'like', "%$q%") ->orWhere('specialty', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('doctors.index', array_merge(compact('rows'), [
            'clinics' => \App\Models\Clinic::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'fee' => 'nullable|numeric|min:0',
            'clinic_id' => 'nullable|exists:clinics,id',
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
            'email' => 'nullable|email',
            'fee' => 'nullable|numeric|min:0',
            'clinic_id' => 'nullable|exists:clinics,id',
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
