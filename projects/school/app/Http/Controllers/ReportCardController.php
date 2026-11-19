<?php
namespace App\Http\Controllers;
use App\Models\Student;
class ReportCardController extends Controller
{
    public function show(Student $student)
    {
        $results = $student->results()->get()->groupBy('exam');
        $attTotal = $student->attendances()->count();
        $attPresent = $student->attendances()->whereIn('status', ['Present','Late'])->count();
        $attPct = $attTotal ? round($attPresent / $attTotal * 100, 1) : null;
        return view('report-card', compact('student', 'results', 'attPct'));
    }
}