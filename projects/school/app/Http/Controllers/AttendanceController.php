<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $rows = Attendance::with(['student'])->latest()->get();
        return view('attendance.index', array_merge(compact('rows'), [
            'students' => \App\Models\Student::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'att_date' => 'required|date',
            'status' => 'required|in:Present,Absent,Late',
            'remark' => 'nullable|string',
        ]);

        Attendance::create($data);
        return back()->with('ok', 'Attendance added.');
    }

    public function update(Request $request, Attendance $row)
    {
        $row->update($request->validate([
            'student_id' => 'required|exists:students,id',
            'att_date' => 'required|date',
            'status' => 'required|in:Present,Absent,Late',
            'remark' => 'nullable|string',
        ]));
        return redirect()->route('attendance.index')->with('ok', 'Attendance updated.');
    }

    public function destroy(Attendance $row)
    {
        $row->delete();
        return back()->with('ok', 'Attendance deleted.');
    }
}
