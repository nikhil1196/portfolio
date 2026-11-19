<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        $rows = Timetable::with(['schoolClass','subject','teacher'])->latest();
        $rows = $rows->paginate(15)->withQueryString();
        return view('timetable.index', array_merge(compact('rows'), [
            'school_classs' => \App\Models\SchoolClass::orderBy('name')->pluck('name', 'id'),
            'subjects' => \App\Models\Subject::orderBy('name')->pluck('name', 'id'),
            'teachers' => \App\Models\Teacher::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'period' => 'required|integer|min:1|max:10',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        Timetable::create($data);
        return back()->with('ok', 'Timetable Entry added.');
    }

    public function update(Request $request, Timetable $row)
    {
        $row->update($request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'period' => 'required|integer|min:1|max:10',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'start_time' => 'required',
            'end_time' => 'required',
        ]));
        return redirect()->route('timetable.index')->with('ok', 'Timetable Entry updated.');
    }

    public function destroy(Timetable $row)
    {
        $row->delete();
        return back()->with('ok', 'Timetable Entry deleted.');
    }
}
