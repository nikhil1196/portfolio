<?php
namespace App\Http\Controllers;
class ExportController extends Controller
{
    private array $map = [
        'contacts' => \App\Models\Contact::class, 'leads' => \App\Models\Lead::class,
        'deals' => \App\Models\Deal::class, 'tasks' => \App\Models\Task::class,
        'activities' => \App\Models\Activity::class, 'products' => \App\Models\Product::class,
        'quotes' => \App\Models\Quote::class,
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