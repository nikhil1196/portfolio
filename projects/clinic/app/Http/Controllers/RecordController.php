<?php
namespace App\Http\Controllers;
use Illuminate\Support\Str;
class RecordController extends Controller
{
    private array $map = [
        'patients' => \App\Models\Patient::class, 'doctors' => \App\Models\Doctor::class,
        'appointments' => \App\Models\Appointment::class, 'prescriptions' => \App\Models\Prescription::class,
        'bills' => \App\Models\Bill::class, 'clinics' => \App\Models\Clinic::class,
        'schedules' => \App\Models\Schedule::class, 'payments' => \App\Models\Payment::class,
    ];
    public function show(string $module, int $id)
    {
        abort_unless(isset($this->map[$module]), 404);
        $r = $this->map[$module]::findOrFail($id);
        $title = Str::title(str_replace('-', ' ', Str::singular($module))) . ' #' . $id;
        return view('record', compact('r', 'title', 'module'));
    }
}