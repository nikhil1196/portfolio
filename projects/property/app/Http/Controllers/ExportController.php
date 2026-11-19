<?php
namespace App\Http\Controllers;
class ExportController extends Controller
{
    private array $map = [
        'properties' => \App\Models\Property::class, 'tenants' => \App\Models\Tenant::class,
        'leases' => \App\Models\Lease::class, 'rents' => \App\Models\Rent::class,
        'requests' => \App\Models\MaintenanceRequest::class, 'expenses' => \App\Models\Expense::class,
        'documents' => \App\Models\Document::class,
    ];
    public function csv(string $module)
    {
        abort_unless(isset($this->map[$module]), 404);
        $rows = $this->map[$module]::all();
        $name = $module . '-' . now()->format('Ymd') . '.csv';
        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            if ($rows->isNotEmpty()) {
                fputcsv($out, array_keys($rows->first()->getAttributes()));
                foreach ($rows as $r) fputcsv($out, $r->getAttributes());
            }
            fclose($out);
        }, $name, ['Content-Type' => 'text/csv']);
    }
}