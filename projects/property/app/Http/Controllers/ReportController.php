<?php
namespace App\Http\Controllers;
class ReportController extends Controller
{
    public function index()
    {
        $sections = [
        ['properties', \App\Models\Property::class],
        ['tenants', \App\Models\Tenant::class],
        ['leases', \App\Models\Lease::class],
        ['rents', \App\Models\Rent::class],
        ['requests', \App\Models\MaintenanceRequest::class],
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
