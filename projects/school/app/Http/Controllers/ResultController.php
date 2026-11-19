<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $rows = Result::with(['student'])->latest()->get();
        return view('results.index', array_merge(compact('rows'), [
            'students' => \App\Models\Student::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'exam' => 'nullable|string',
            'subject' => 'required|string',
            'marks' => 'required|numeric',
            'max_marks' => 'nullable|numeric',
            'grade' => 'nullable|string|max:5',
        ]);

        Result::create($data);
        return back()->with('ok', 'Result added.');
    }

    public function update(Request $request, Result $row)
    {
        $row->update($request->validate([
            'student_id' => 'required|exists:students,id',
            'exam' => 'nullable|string',
            'subject' => 'required|string',
            'marks' => 'required|numeric',
            'max_marks' => 'nullable|numeric',
            'grade' => 'nullable|string|max:5',
        ]));
        return redirect()->route('results.index')->with('ok', 'Result updated.');
    }

    public function destroy(Result $row)
    {
        $row->delete();
        return back()->with('ok', 'Result deleted.');
    }
}
