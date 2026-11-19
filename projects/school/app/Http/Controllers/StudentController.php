<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $rows = Student::with(['schoolClass'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('name', 'like', "%$q%") ->orWhere('roll_no', 'like', "%$q%") ->orWhere('guardian', 'like', "%$q%") ->orWhere('phone', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
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
            'parent_email' => 'nullable|email',
            'document' => 'nullable|file|max:4096',
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'status' => 'required|in:Active,Inactive,Alumni',
        ]);

        if ($request->hasFile('document')) { $data['document'] = $request->file('document')->store('docs', 'public'); }
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
            'parent_email' => 'nullable|email',
            'document' => 'nullable|file|max:4096',
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
