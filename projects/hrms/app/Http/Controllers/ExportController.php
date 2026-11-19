<?php
namespace App\Http\Controllers;
class ExportController extends Controller
{
    private array $map = [
        'departments' => \App\Models\Department::class, 'employees' => \App\Models\Employee::class,
        'attendance' => \App\Models\HrAttendance::class, 'leaves' => \App\Models\Leave::class,
        'payroll' => \App\Models\Payroll::class, 'holidays' => \App\Models\Holiday::class,
        'announcements' => \App\Models\Announcement::class, 'documents' => \App\Models\Document::class,
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