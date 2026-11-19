<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $rows = Assignment::with(['subject','schoolClass','teacher'])->latest()->get();
        return view('assignments.index', array_merge(compact('rows'), [
            'subjects' => \App\Models\Subject::orderBy('name')->pluck('name', 'id'),
            'school_classs' => \App\Models\SchoolClass::orderBy('name')->pluck('name', 'id'),
            'teachers' => \App\Models\Teacher::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:school_classes,id',
            'teacher_id' => 'required|exists:teachers,id',
            'due_date' => 'required|date',
            'description' => 'nullable|string',
            'status' => 'required|in:Open,Closed',
        ]);

        Assignment::create($data);
        return back()->with('ok', 'Assignment added.');
    }

    public function update(Request $request, Assignment $row)
    {
        $row->update($request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:school_classes,id',
            'teacher_id' => 'required|exists:teachers,id',
            'due_date' => 'required|date',
            'description' => 'nullable|string',
            'status' => 'required|in:Open,Closed',
        ]));
        return redirect()->route('assignments.index')->with('ok', 'Assignment updated.');
    }

    public function destroy(Assignment $row)
    {
        $row->delete();
        return back()->with('ok', 'Assignment deleted.');
    }
}
