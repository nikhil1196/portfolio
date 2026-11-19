<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function index()
    {
        $rows = SchoolClass::with(['teacher'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('name', 'like', "%$q%") ->orWhere('section', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('classes.index', array_merge(compact('rows'), [
            'teachers' => \App\Models\Teacher::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'nullable|string|max:10',
            'teacher_id' => 'nullable|exists:teachers,id',
            'room' => 'nullable|string|max:20',
        ]);

        SchoolClass::create($data);
        return back()->with('ok', 'Class added.');
    }

    public function update(Request $request, SchoolClass $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'section' => 'nullable|string|max:10',
            'teacher_id' => 'nullable|exists:teachers,id',
            'room' => 'nullable|string|max:20',
        ]));
        return redirect()->route('classes.index')->with('ok', 'Class updated.');
    }

    public function destroy(SchoolClass $row)
    {
        $row->delete();
        return back()->with('ok', 'Class deleted.');
    }
}
