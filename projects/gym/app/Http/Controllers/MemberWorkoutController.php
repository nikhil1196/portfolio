<?php

namespace App\Http\Controllers;

use App\Models\MemberWorkout;
use Illuminate\Http\Request;

class MemberWorkoutController extends Controller
{
    public function index()
    {
        $rows = MemberWorkout::with(['member','workoutPlan'])->latest()->get();
        return view('member-workouts.index', array_merge(compact('rows'), [
            'members' => \App\Models\Member::orderBy('name')->pluck('name', 'id'),
            'workout_plans' => \App\Models\WorkoutPlan::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id' => 'required|exists:members,id',
            'workout_plan_id' => 'required|exists:workout_plans,id',
            'start_date' => 'required|date',
            'status' => 'required|in:Active,Completed,Paused',
        ]);

        MemberWorkout::create($data);
        return back()->with('ok', 'Member Plan Assignment added.');
    }

    public function update(Request $request, MemberWorkout $row)
    {
        $row->update($request->validate([
            'member_id' => 'required|exists:members,id',
            'workout_plan_id' => 'required|exists:workout_plans,id',
            'start_date' => 'required|date',
            'status' => 'required|in:Active,Completed,Paused',
        ]));
        return redirect()->route('member-workouts.index')->with('ok', 'Member Plan Assignment updated.');
    }

    public function destroy(MemberWorkout $row)
    {
        $row->delete();
        return back()->with('ok', 'Member Plan Assignment deleted.');
    }
}
