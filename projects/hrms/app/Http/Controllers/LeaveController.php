<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        $rows = Leave::with(['employee'])->latest()->get();
        return view('leaves.index', array_merge(compact('rows'), [
            'employees' => \App\Models\Employee::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'emp_id' => 'required|exists:employees,id',
            'type' => 'nullable|string',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'reason' => 'nullable|string',
            'status' => 'required|in:Pending,Approved,Rejected',
        ]);

        Leave::create($data);
        return back()->with('ok', 'Leave added.');
    }

    public function update(Request $request, Leave $row)
    {
        $row->update($request->validate([
            'emp_id' => 'required|exists:employees,id',
            'type' => 'nullable|string',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'reason' => 'nullable|string',
            'status' => 'required|in:Pending,Approved,Rejected',
        ]));
        return redirect()->route('leaves.index')->with('ok', 'Leave updated.');
    }

    public function destroy(Leave $row)
    {
        $row->delete();
        return back()->with('ok', 'Leave deleted.');
    }

    public function setStatus(Leave $row, Request $request)
    {
        $data = $request->validate(["status" => "required|in:Pending,Approved,Rejected"]);
        $row->update($data);
        return back()->with("ok", "Leave {$data["status"]}.");
    }
}