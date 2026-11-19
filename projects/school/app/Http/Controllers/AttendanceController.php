<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $rows = Attendance::with(['student'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('remark', 'like', "%$q%"); }); }
                if (request('from')) { $rows->whereDate('att_date', '>=', request('from')); }
        if (request('to'))   { $rows->whereDate('att_date', '<=', request('to')); }
        $rows = $rows->paginate(15)->withQueryString();
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

        $att = Attendance::create($data);
        $stu = \App\Models\Student::find($data['student_id']);
        if ($data['status'] === 'Absent' && $stu && $stu->parent_email) {
            try { \Illuminate\Support\Facades\Mail::raw($stu->name . ' was marked Absent on ' . $data['att_date'] . '.', fn ($m) => $m->to($stu->parent_email)->subject('Absence notification')); } catch (\Throwable $e) {}
        }
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
