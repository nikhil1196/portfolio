<?php
namespace App\Http\Controllers;
class ReportController extends Controller
{
    public function index()
    {
        $sections = [
        ['patients', \App\Models\Patient::class],
        ['doctors', \App\Models\Doctor::class],
        ['appointments', \App\Models\Appointment::class],
        ['prescriptions', \App\Models\Prescription::class],
        ['bills', \App\Models\Bill::class],
        ['clinics', \App\Models\Clinic::class],
        ['schedules', \App\Models\Schedule::class],
        ['payments', \App\Models\Payment::class],
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
