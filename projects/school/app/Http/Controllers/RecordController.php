<?php
namespace App\Http\Controllers;
use Illuminate\Support\Str;
class RecordController extends Controller
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
    public function show(string $module, int $id)
    {
        abort_unless(isset($this->map[$module]), 404);
        $r = $this->map[$module]::findOrFail($id);
        $title = Str::title(str_replace('-', ' ', Str::singular($module))) . ' #' . $id;
        return view('record', compact('r', 'title', 'module'));
    }
}