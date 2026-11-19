<?php
namespace App\Http\Controllers;
class ReportController extends Controller
{
    public function index()
    {
        $sections = [
        ['departments', \App\Models\Department::class],
        ['employees', \App\Models\Employee::class],
        ['attendance', \App\Models\HrAttendance::class],
        ['leaves', \App\Models\Leave::class],
        ['payroll', \App\Models\Payroll::class],
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
