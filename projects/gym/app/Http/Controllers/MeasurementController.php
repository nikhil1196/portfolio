<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    public function index()
    {
        $rows = Measurement::with(['member']);
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('notes', 'like', "%$q%"); }); }
        $rows = $rows->latest()->paginate(15)->withQueryString();
        return view('measurements.index', array_merge(compact('rows'), [
            'members' => \App\Models\Member::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id' => 'required|exists:members,id',
            'measured_on' => 'required|date',
            'weight_kg' => 'nullable|numeric',
            'height_cm' => 'nullable|numeric',
            'chest_cm' => 'nullable|numeric',
            'waist_cm' => 'nullable|numeric',
            'arms_cm' => 'nullable|numeric',
            'body_fat' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        Measurement::create($data);
        return back()->with('ok', 'Measurement added.');
    }

    public function update(Request $request, Measurement $row)
    {
        $row->update($request->validate([
            'member_id' => 'required|exists:members,id',
            'measured_on' => 'required|date',
            'weight_kg' => 'nullable|numeric',
            'height_cm' => 'nullable|numeric',
            'chest_cm' => 'nullable|numeric',
            'waist_cm' => 'nullable|numeric',
            'arms_cm' => 'nullable|numeric',
            'body_fat' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]));
        return redirect()->route('measurements.index')->with('ok', 'Measurement updated.');
    }

    public function destroy(Measurement $row)
    {
        $row->delete();
        return back()->with('ok', 'Measurement deleted.');
    }
}
