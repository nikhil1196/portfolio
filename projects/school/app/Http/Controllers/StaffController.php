<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $rows = Staff::latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('name', 'like', "%$q%") ->orWhere('role', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('staff.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string',
            'dept' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'joined' => 'nullable|date',
            'status' => 'required|in:Active,Inactive',
        ]);

        Staff::create($data);
        return back()->with('ok', 'Staff added.');
    }

    public function update(Request $request, Staff $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string',
            'dept' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'joined' => 'nullable|date',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('staff.index')->with('ok', 'Staff updated.');
    }

    public function destroy(Staff $row)
    {
        $row->delete();
        return back()->with('ok', 'Staff deleted.');
    }
}
