<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Member;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('attendance.index', [
            'members' => Member::where('status', 'Active')->orderBy('name')->pluck('name', 'id'),
            'log'     => Attendance::with('member')->when(request('from'), fn($q)=>$q->whereDate('check_in','>=',request('from')))->when(request('to'), fn($q)=>$q->whereDate('check_in','<=',request('to')))->latest('check_in')->paginate(15)->withQueryString(),
        ]);
    }

    public function checkin(Request $request)
    {
        $request->validate(['member_id' => 'required|exists:members,id']);
        Attendance::create(['member_id' => $request->member_id, 'check_in' => now()]);
        return back()->with('ok', 'Checked in.');
    }

    public function checkout(Attendance $attendance)
    {
        $attendance->update(['check_out' => now()]);
        return back()->with('ok', 'Checked out.');
    }
}
