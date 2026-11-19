<?php

namespace App\Http\Controllers;

use App\Models\HrAttendance;
use Illuminate\Http\Request;

class HrAttendanceController extends Controller
{
    public function index()
    {
        $rows = HrAttendance::with(['employee'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('status', 'like', "%$q%"); }); }
                if (request('from')) { $rows->whereDate('work_date', '>=', request('from')); }
        if (request('to'))   { $rows->whereDate('work_date', '<=', request('to')); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('attendance.index', array_merge(compact('rows'), [
            'employees' => \App\Models\Employee::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'emp_id' => 'required|exists:employees,id',
            'work_date' => 'required|date',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'status' => 'required|in:Present,Absent,Leave,Half Day,WFH',
        ]);

        $data['late'] = !empty($data['check_in']) && $data['check_in'] > '09:30';
        HrAttendance::create($data);
        return back()->with('ok', 'Attendance added.');
    }

    public function update(Request $request, HrAttendance $row)
    {
        $row->update($request->validate([
            'emp_id' => 'required|exists:employees,id',
            'work_date' => 'required|date',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'status' => 'required|in:Present,Absent,Leave,Half Day,WFH',
        ]));
        return redirect()->route('attendance.index')->with('ok', 'Attendance updated.');
    }

    public function destroy(HrAttendance $row)
    {
        $row->delete();
        return back()->with('ok', 'Attendance deleted.');
    }
}
