<?php
namespace App\Http\Controllers;
use App\Models\HrAttendance;
use App\Models\Employee;
class AttendanceReportController extends Controller
{
    public function index()
    {
        $month = request('month', now()->format('Y-m'));
        [$y, $m] = explode('-', $month);
        $rows = Employee::orderBy('name')->get()->map(function ($e) use ($y, $m) {
            $q = fn () => HrAttendance::where('emp_id', $e->id)->whereYear('work_date', $y)->whereMonth('work_date', $m);
            $total = $q()->count();
            return [
                'emp' => $e->name, 'code' => $e->emp_code, 'total' => $total,
                'present' => $q()->where('status', 'Present')->count(),
                'absent'  => $q()->where('status', 'Absent')->count(),
                'late'    => $q()->where('late', 1)->count(),
            ];
        })->filter(fn ($r) => $r['total'] > 0);
        return view('attendance-report', compact('rows', 'month'));
    }
}