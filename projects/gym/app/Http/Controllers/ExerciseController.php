<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index()
    {
        $rows = Exercise::latest()->get();
        return view('exercises.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'muscle_group' => 'nullable|string',
            'equipment' => 'nullable|string',
            'difficulty' => 'required|in:Beginner,Intermediate,Advanced',
            'video_url' => 'nullable|url|max:255',
            'description' => 'nullable|string',
        ]);

        Exercise::create($data);
        return back()->with('ok', 'Exercise added.');
    }

    public function update(Request $request, Exercise $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'muscle_group' => 'nullable|string',
            'equipment' => 'nullable|string',
            'difficulty' => 'required|in:Beginner,Intermediate,Advanced',
            'video_url' => 'nullable|url|max:255',
            'description' => 'nullable|string',
        ]));
        return redirect()->route('exercises.index')->with('ok', 'Exercise updated.');
    }

    public function destroy(Exercise $row)
    {
        $row->delete();
        return back()->with('ok', 'Exercise deleted.');
    }
}
