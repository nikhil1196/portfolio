<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $rows = Activity::with(['lead'])->latest()->get();
        return view('activities.index', array_merge(compact('rows'), [
            'leads' => \App\Models\Lead::orderBy('title')->pluck('title', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'type' => 'required|in:Call,Meeting,Email,Note',
            'summary' => 'required|string|max:255',
            'due_at' => 'required|date',
            'done' => 'nullable|boolean',
        ]);

        Activity::create($data);
        return back()->with('ok', 'Activity added.');
    }

    public function update(Request $request, Activity $row)
    {
        $row->update($request->validate([
            'lead_id' => 'required|exists:leads,id',
            'type' => 'required|in:Call,Meeting,Email,Note',
            'summary' => 'required|string|max:255',
            'due_at' => 'required|date',
            'done' => 'nullable|boolean',
        ]));
        return redirect()->route('activities.index')->with('ok', 'Activity updated.');
    }

    public function destroy(Activity $row)
    {
        $row->delete();
        return back()->with('ok', 'Activity deleted.');
    }
}
