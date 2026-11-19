<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $rows = Material::with(['subject','schoolClass'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('title', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('materials.index', array_merge(compact('rows'), [
            'subjects' => \App\Models\Subject::orderBy('name')->pluck('name', 'id'),
            'school_classs' => \App\Models\SchoolClass::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:school_classes,id',
            'type' => 'required|in:Notes,PDF,Link,Video',
            'url' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        Material::create($data);
        return back()->with('ok', 'Study Material added.');
    }

    public function update(Request $request, Material $row)
    {
        $row->update($request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:school_classes,id',
            'type' => 'required|in:Notes,PDF,Link,Video',
            'url' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('materials.index')->with('ok', 'Study Material updated.');
    }

    public function destroy(Material $row)
    {
        $row->delete();
        return back()->with('ok', 'Study Material deleted.');
    }
}
