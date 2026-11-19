<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $rows = Teacher::latest()->get();
        return view('teachers.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'qualification' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        Teacher::create($data);
        return back()->with('ok', 'Teacher added.');
    }

    public function update(Request $request, Teacher $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'qualification' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('teachers.index')->with('ok', 'Teacher updated.');
    }

    public function destroy(Teacher $row)
    {
        $row->delete();
        return back()->with('ok', 'Teacher deleted.');
    }
}
