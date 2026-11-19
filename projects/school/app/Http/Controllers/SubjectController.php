<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $rows = Subject::with(['schoolClass','teacher'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('name', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('subjects.index', array_merge(compact('rows'), [
            'school_classs' => \App\Models\SchoolClass::orderBy('name')->pluck('name', 'id'),
            'teachers' => \App\Models\Teacher::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string',
            'class_id' => 'required|exists:school_classes,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'status' => 'required|in:Active,Inactive',
        ]);

        Subject::create($data);
        return back()->with('ok', 'Subject added.');
    }

    public function update(Request $request, Subject $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string',
            'class_id' => 'required|exists:school_classes,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('subjects.index')->with('ok', 'Subject updated.');
    }

    public function destroy(Subject $row)
    {
        $row->delete();
        return back()->with('ok', 'Subject deleted.');
    }
}
