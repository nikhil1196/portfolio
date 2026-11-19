<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        $rows = Leave::with(['employee'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('type', 'like', "%$q%") ->orWhere('reason', 'like', "%$q%"); }); }
                if (request('status')) { $rows->where('status', request('status')); }
        $rows = $rows->paginate(15)->withQueryString();
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
        if ($data['status'] === 'Approved' && $row->status !== 'Approved') {
            $days = \Carbon\Carbon::parse($row->from_date)->diffInDays(\Carbon\Carbon::parse($row->to_date)) + 1;
            $row->employee?->decrement('leave_balance', (int) $days);
        }
        $row->update($data);
        return back()->with("ok", "Leave {$data["status"]}.");
    }
}