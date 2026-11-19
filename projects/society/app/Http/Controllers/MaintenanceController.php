<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $rows = Maintenance::with(['unit'])->latest()->get();
        return view('maintenance.index', array_merge(compact('rows'), [
            'units' => \App\Models\Unit::orderBy('flat_no')->pluck('flat_no', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'month' => 'required|string|max:10',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:Paid,Due,Overdue',
            'paid_at' => 'nullable|date',
        ]);

        Maintenance::create($data);
        return back()->with('ok', 'Maintenance Bill added.');
    }

    public function update(Request $request, Maintenance $row)
    {
        $row->update($request->validate([
            'unit_id' => 'required|exists:units,id',
            'month' => 'required|string|max:10',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:Paid,Due,Overdue',
            'paid_at' => 'nullable|date',
        ]));
        return redirect()->route('maintenance.index')->with('ok', 'Maintenance Bill updated.');
    }

    public function destroy(Maintenance $row)
    {
        $row->delete();
        return back()->with('ok', 'Maintenance Bill deleted.');
    }
}
