<?php

namespace App\Http\Controllers;

use App\Models\HrAttendance;
use Illuminate\Http\Request;

class HrAttendanceController extends Controller
{
    public function index()
    {
        $rows = HrAttendance::with(['employee'])->latest()->get();
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
            'status' => 'required|in:Present,Absent,Leave,Half Day,WFH',
        ]);

        HrAttendance::create($data);
        return back()->with('ok', 'Attendance added.');
    }

    public function update(Request $request, HrAttendance $row)
    {
        $row->update($request->validate([
            'emp_id' => 'required|exists:employees,id',
            'work_date' => 'required|date',
            'check_in' => 'nullable',
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
