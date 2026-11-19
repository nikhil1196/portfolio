<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index()
    {
        $rows = Visitor::with(['unit'])->latest()->get();
        return view('visitors.index', array_merge(compact('rows'), [
            'units' => \App\Models\Unit::orderBy('flat_no')->pluck('flat_no', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'purpose' => 'nullable|string',
            'check_in' => 'required|date',
            'check_out' => 'nullable|date',
            'status' => 'required|in:Inside,Left',
        ]);

        Visitor::create($data);
        return back()->with('ok', 'Visitor added.');
    }

    public function update(Request $request, Visitor $row)
    {
        $row->update($request->validate([
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'purpose' => 'nullable|string',
            'check_in' => 'required|date',
            'check_out' => 'nullable|date',
            'status' => 'required|in:Inside,Left',
        ]));
        return redirect()->route('visitors.index')->with('ok', 'Visitor updated.');
    }

    public function destroy(Visitor $row)
    {
        $row->delete();
        return back()->with('ok', 'Visitor deleted.');
    }
}
