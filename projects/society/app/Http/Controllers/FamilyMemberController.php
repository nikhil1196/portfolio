<?php

namespace App\Http\Controllers;

use App\Models\FamilyMember;
use Illuminate\Http\Request;

class FamilyMemberController extends Controller
{
    public function index()
    {
        $rows = FamilyMember::with(['unit','resident'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('name', 'like', "%$q%") ->orWhere('relation', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('members.index', array_merge(compact('rows'), [
            'units' => \App\Models\Unit::orderBy('flat_no')->pluck('flat_no', 'id'),
            'residents' => \App\Models\Resident::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'resident_id' => 'required|exists:residents,id',
            'name' => 'required|string|max:255',
            'relation' => 'nullable|string|max:60',
            'phone' => 'nullable|string|max:20',
            'occupation' => 'nullable|string|max:120',
            'status' => 'required|in:Active,Inactive',
        ]);

        FamilyMember::create($data);
        return back()->with('ok', 'Family Member added.');
    }

    public function update(Request $request, FamilyMember $row)
    {
        $row->update($request->validate([
            'unit_id' => 'required|exists:units,id',
            'resident_id' => 'required|exists:residents,id',
            'name' => 'required|string|max:255',
            'relation' => 'nullable|string|max:60',
            'phone' => 'nullable|string|max:20',
            'occupation' => 'nullable|string|max:120',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('members.index')->with('ok', 'Family Member updated.');
    }

    public function destroy(FamilyMember $row)
    {
        $row->delete();
        return back()->with('ok', 'Family Member deleted.');
    }
}
