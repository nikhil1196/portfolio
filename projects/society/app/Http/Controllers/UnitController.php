<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $rows = Unit::latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('flat_no', 'like', "%$q%") ->orWhere('block', 'like', "%$q%") ->orWhere('owner_name', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('units.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'block' => 'nullable|string|max:5',
            'flat_no' => 'required|string|max:15',
            'floor' => 'nullable|integer',
            'type' => 'nullable|string',
            'area_sqft' => 'nullable|integer',
            'status' => 'required|in:Occupied,Vacant',
        ]);

        Unit::create($data);
        return back()->with('ok', 'Unit added.');
    }

    public function update(Request $request, Unit $row)
    {
        $row->update($request->validate([
            'block' => 'nullable|string|max:5',
            'flat_no' => 'required|string|max:15',
            'floor' => 'nullable|integer',
            'type' => 'nullable|string',
            'area_sqft' => 'nullable|integer',
            'status' => 'required|in:Occupied,Vacant',
        ]));
        return redirect()->route('units.index')->with('ok', 'Unit updated.');
    }

    public function destroy(Unit $row)
    {
        $row->delete();
        return back()->with('ok', 'Unit deleted.');
    }
}
