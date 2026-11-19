<?php
namespace App\Http\Controllers;
class ExportController extends Controller
{
    private array $map = [
        'patients' => \App\Models\Patient::class, 'doctors' => \App\Models\Doctor::class,
        'appointments' => \App\Models\Appointment::class, 'bills' => \App\Models\Bill::class,
        'payments' => \App\Models\Payment::class, 'clinics' => \App\Models\Clinic::class,
        'schedules' => \App\Models\Schedule::class, 'prescriptions' => \App\Models\Prescription::class,
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