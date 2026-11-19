<?php
namespace App\Http\Controllers;
use Illuminate\Support\Str;
class RecordController extends Controller
{
    private array $map = [
        'members' => \App\Models\Member::class, 'plans' => \App\Models\Plan::class,
        'trainers' => \App\Models\Trainer::class, 'payments' => \App\Models\Payment::class,
        'exercises' => \App\Models\Exercise::class, 'workout-plans' => \App\Models\WorkoutPlan::class,
        'workout-items' => \App\Models\WorkoutItem::class, 'member-workouts' => \App\Models\MemberWorkout::class,
        'measurements' => \App\Models\Measurement::class, 'pt-sessions' => \App\Models\PtSession::class,
        'gym-classes' => \App\Models\GymClass::class, 'class-bookings' => \App\Models\ClassBooking::class,
        'attendance' => \App\Models\Attendance::class,
    ];
    public function show(string $module, int $id)
    {
        abort_unless(isset($this->map[$module]), 404);
        $r = $this->map[$module]::findOrFail($id);
        $title = Str::title(str_replace('-', ' ', Str::singular($module))) . ' #' . $id;
        return view('record', compact('r', 'title', 'module'));
    }
}