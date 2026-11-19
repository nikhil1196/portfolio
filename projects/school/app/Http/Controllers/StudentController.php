<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $rows = Student::with(['schoolClass'])->latest()->get();
        return view('students.index', array_merge(compact('rows'), [
            'school_classes' => \App\Models\SchoolClass::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'roll_no' => 'nullable|string|max:20',
            'class_id' => 'nullable|exists:school_classes,id',
            'guardian' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'status' => 'required|in:Active,Inactive,Alumni',
        ]);

        Student::create($data);
        return back()->with('ok', 'Student added.');
    }

    public function update(Request $request, Student $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'roll_no' => 'nullable|string|max:20',
            'class_id' => 'nullable|exists:school_classes,id',
            'guardian' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'status' => 'required|in:Active,Inactive,Alumni',
        ]));
        return redirect()->route('students.index')->with('ok', 'Student updated.');
    }

    public function destroy(Student $row)
    {
        $row->delete();
        return back()->with('ok', 'Student deleted.');
    }
}
