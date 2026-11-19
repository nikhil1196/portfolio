<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $rows = Exam::with(['schoolClass','subject'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('name', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('exams.index', array_merge(compact('rows'), [
            'school_classs' => \App\Models\SchoolClass::orderBy('name')->pluck('name', 'id'),
            'subjects' => \App\Models\Subject::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_date' => 'required|date',
            'max_marks' => 'required|integer|min:1',
            'status' => 'required|in:Scheduled,Ongoing,Completed',
        ]);

        Exam::create($data);
        return back()->with('ok', 'Exam added.');
    }

    public function update(Request $request, Exam $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_date' => 'required|date',
            'max_marks' => 'required|integer|min:1',
            'status' => 'required|in:Scheduled,Ongoing,Completed',
        ]));
        return redirect()->route('exams.index')->with('ok', 'Exam updated.');
    }

    public function destroy(Exam $row)
    {
        $row->delete();
        return back()->with('ok', 'Exam deleted.');
    }
}
