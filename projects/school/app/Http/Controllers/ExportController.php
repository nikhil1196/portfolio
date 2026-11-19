<?php
namespace App\Http\Controllers;
class ExportController extends Controller
{
    private array $map = [
        'students' => \App\Models\Student::class, 'teachers' => \App\Models\Teacher::class,
        'classes' => \App\Models\SchoolClass::class, 'fees' => \App\Models\Fee::class,
        'results' => \App\Models\Result::class, 'attendance' => \App\Models\Attendance::class,
        'notices' => \App\Models\Notice::class, 'subjects' => \App\Models\Subject::class,
        'staff' => \App\Models\Staff::class, 'timetable' => \App\Models\Timetable::class,
        'materials' => \App\Models\Material::class, 'assignments' => \App\Models\Assignment::class,
        'submissions' => \App\Models\Submission::class, 'exams' => \App\Models\Exam::class,
        'fee-structures' => \App\Models\FeeStructure::class,
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