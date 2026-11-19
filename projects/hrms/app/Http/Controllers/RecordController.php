<?php
namespace App\Http\Controllers;
use Illuminate\Support\Str;
class RecordController extends Controller
{
    private array $map = [
        'departments' => \App\Models\Department::class, 'employees' => \App\Models\Employee::class,
        'attendance' => \App\Models\HrAttendance::class, 'leaves' => \App\Models\Leave::class,
        'payroll' => \App\Models\Payroll::class, 'holidays' => \App\Models\Holiday::class,
        'announcements' => \App\Models\Announcement::class, 'documents' => \App\Models\Document::class,
    ];
    public function show(string $module, int $id)
    {
        abort_unless(isset($this->map[$module]), 404);
        $r = $this->map[$module]::findOrFail($id);
        $title = Str::title(str_replace('-', ' ', Str::singular($module))) . ' #' . $id;
        return view('record', compact('r', 'title', 'module'));
    }
}