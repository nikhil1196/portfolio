<?php
namespace App\Http\Controllers;
class ReportController extends Controller
{
    public function index()
    {
        $sections = [
        ['students', \App\Models\Student::class],
        ['teachers', \App\Models\Teacher::class],
        ['classes', \App\Models\SchoolClass::class],
        ['fees', \App\Models\Fee::class],
        ['results', \App\Models\Result::class],
        ['attendance', \App\Models\Attendance::class],
        ['notices', \App\Models\Notice::class],
        ];
        $reports = [];
        foreach ($sections as [$uri, $model]) {
            $byStatus = [];
            try {
                $byStatus = $model::selectRaw('status, COUNT(*) as c')->groupBy('status')->pluck('c', 'status')->toArray();
            } catch (\Throwable $e) {}
            $reports[] = [
                'uri' => $uri, 'title' => ucfirst($uri),
                'total' => $model::count(),
                'month' => $model::where('created_at', '>=', now()->startOfMonth())->count(),
                'byStatus' => $byStatus,
            ];
        }
        return view('reports.index', compact('reports'));
    }
}
