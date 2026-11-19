<?php

namespace App\Http\Controllers;

use App\Models\GymClass;
use Illuminate\Http\Request;

class GymClassController extends Controller
{
    public function index()
    {
        $rows = GymClass::with(['trainer']);
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('name', 'like', "%$q%") ->orWhere('day', 'like', "%$q%"); }); }
        $rows = $rows->latest()->paginate(15)->withQueryString();
        return view('gym-classes.index', array_merge(compact('rows'), [
            'trainers' => \App\Models\Trainer::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'trainer_id' => 'nullable|exists:trainers,id',
            'day' => 'nullable|string',
            'start_time' => 'nullable',
            'duration_min' => 'nullable|integer',
            'capacity' => 'nullable|integer',
            'status' => 'required|in:Active,Inactive',
        ]);

        GymClass::create($data);
        return back()->with('ok', 'Class added.');
    }

    public function update(Request $request, GymClass $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'trainer_id' => 'nullable|exists:trainers,id',
            'day' => 'nullable|string',
            'start_time' => 'nullable',
            'duration_min' => 'nullable|integer',
            'capacity' => 'nullable|integer',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('gym-classes.index')->with('ok', 'Class updated.');
    }

    public function destroy(GymClass $row)
    {
        $row->delete();
        return back()->with('ok', 'Class deleted.');
    }
}
