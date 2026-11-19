<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index()
    {
        $rows = Submission::with(['assignment','student'])->latest()->get();
        return view('submissions.index', array_merge(compact('rows'), [
            'assignments' => \App\Models\Assignment::orderBy('title')->pluck('title', 'id'),
            'students' => \App\Models\Student::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'student_id' => 'required|exists:students,id',
            'submitted_at' => 'required|date',
            'notes' => 'nullable|string',
            'marks' => 'nullable|integer|min:0',
            'status' => 'required|in:Submitted,Late,Graded',
        ]);

        Submission::create($data);
        return back()->with('ok', 'Submission added.');
    }

    public function update(Request $request, Submission $row)
    {
        $row->update($request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'student_id' => 'required|exists:students,id',
            'submitted_at' => 'required|date',
            'notes' => 'nullable|string',
            'marks' => 'nullable|integer|min:0',
            'status' => 'required|in:Submitted,Late,Graded',
        ]));
        return redirect()->route('submissions.index')->with('ok', 'Submission updated.');
    }

    public function destroy(Submission $row)
    {
        $row->delete();
        return back()->with('ok', 'Submission deleted.');
    }
}
