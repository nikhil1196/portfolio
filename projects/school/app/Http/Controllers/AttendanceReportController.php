<?php
namespace App\Http\Controllers;
use App\Models\Attendance;
use App\Models\Student;
class AttendanceReportController extends Controller
{
    public function index()
    {
        $month = request('month', now()->format('Y-m'));
        [$y, $m] = explode('-', $month);
        $rows = Student::orderBy('name')->get()->map(function ($s) use ($y, $m) {
            $q = Attendance::where('student_id', $s->id)->whereYear('att_date', $y)->whereMonth('att_date', $m);
            $total = (clone $q)->count();
            return [
                'student' => $s->name, 'roll' => $s->roll_no, 'total' => $total,
                'present' => (clone $q)->where('status', 'Present')->count(),
                'absent'  => (clone $q)->where('status', 'Absent')->count(),
                'late'    => (clone $q)->where('status', 'Late')->count(),
                'pct'     => $total ? round((clone $q)->whereIn('status', ['Present','Late'])->count() / $total * 100, 1) : null,
            ];
        })->filter(fn ($r) => $r['total'] > 0);
        return view('attendance-report', compact('rows', 'month'));
    }
}