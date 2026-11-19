<?php
namespace App\Http\Controllers;
use Illuminate\Support\Str;
class ExportController extends Controller
{
    private array $map = [
        'members' => \App\Models\Member::class, 'payments' => \App\Models\Payment::class,
        'attendance' => \App\Models\Attendance::class, 'trainers' => \App\Models\Trainer::class,
        'exercises' => \App\Models\Exercise::class, 'measurements' => \App\Models\Measurement::class,
        'plans' => \App\Models\Plan::class, 'workout-plans' => \App\Models\WorkoutPlan::class,
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