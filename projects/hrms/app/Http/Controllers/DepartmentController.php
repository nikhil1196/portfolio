<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $rows = Department::latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('name', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('departments.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'head' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        Department::create($data);
        return back()->with('ok', 'Department added.');
    }

    public function update(Request $request, Department $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'head' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('departments.index')->with('ok', 'Department updated.');
    }

    public function destroy(Department $row)
    {
        $row->delete();
        return back()->with('ok', 'Department deleted.');
    }
}
