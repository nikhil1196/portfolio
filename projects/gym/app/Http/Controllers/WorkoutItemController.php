<?php

namespace App\Http\Controllers;

use App\Models\WorkoutItem;
use Illuminate\Http\Request;

class WorkoutItemController extends Controller
{
    public function index()
    {
        $rows = WorkoutItem::with(['workoutPlan','exercise'])->latest()->paginate(15)->withQueryString();
        return view('workout-items.index', array_merge(compact('rows'), [
            'workout_plans' => \App\Models\WorkoutPlan::orderBy('name')->pluck('name', 'id'),
            'exercises' => \App\Models\Exercise::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'workout_plan_id' => 'required|exists:workout_plans,id',
            'exercise_id' => 'required|exists:exercises,id',
            'day' => 'nullable|string',
            'sets' => 'nullable|integer|min:1',
            'reps' => 'nullable|integer|min:1',
        ]);

        WorkoutItem::create($data);
        return back()->with('ok', 'Plan Exercise added.');
    }

    public function update(Request $request, WorkoutItem $row)
    {
        $row->update($request->validate([
            'workout_plan_id' => 'required|exists:workout_plans,id',
            'exercise_id' => 'required|exists:exercises,id',
            'day' => 'nullable|string',
            'sets' => 'nullable|integer|min:1',
            'reps' => 'nullable|integer|min:1',
        ]));
        return redirect()->route('workout-items.index')->with('ok', 'Plan Exercise updated.');
    }

    public function destroy(WorkoutItem $row)
    {
        $row->delete();
        return back()->with('ok', 'Plan Exercise deleted.');
    }
}
