<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function index()
    {
        $rows = Resident::with(['unit'])->latest()->get();
        return view('residents.index', array_merge(compact('rows'), [
            'units' => \App\Models\Unit::orderBy('flat_no')->pluck('flat_no', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'role' => 'required|in:Owner,Tenant,Family Member',
            'status' => 'required|in:Active,Moved Out',
        ]);

        Resident::create($data);
        return back()->with('ok', 'Resident added.');
    }

    public function update(Request $request, Resident $row)
    {
        $row->update($request->validate([
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'role' => 'required|in:Owner,Tenant,Family Member',
            'status' => 'required|in:Active,Moved Out',
        ]));
        return redirect()->route('residents.index')->with('ok', 'Resident updated.');
    }

    public function destroy(Resident $row)
    {
        $row->delete();
        return back()->with('ok', 'Resident deleted.');
    }
}
