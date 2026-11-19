<?php

namespace App\Http\Controllers;

use App\Models\WorkoutPlan;
use Illuminate\Http\Request;

class WorkoutPlanController extends Controller
{
    public function index()
    {
        $rows = WorkoutPlan::latest()->paginate(15)->withQueryString();
        return view('workout-plans.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'goal' => 'nullable|string',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
            'duration_weeks' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
        ]);

        WorkoutPlan::create($data);
        return back()->with('ok', 'Workout Plan added.');
    }

    public function update(Request $request, WorkoutPlan $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'goal' => 'nullable|string',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
            'duration_weeks' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
        ]));
        return redirect()->route('workout-plans.index')->with('ok', 'Workout Plan updated.');
    }

    public function destroy(WorkoutPlan $row)
    {
        $row->delete();
        return back()->with('ok', 'Workout Plan deleted.');
    }
}
