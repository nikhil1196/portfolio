<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function index()
    {
        $rows = Holiday::latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('name', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('holidays.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'hdate' => 'required|date',
            'type' => 'required|in:Public,Festival,Company,Optional',
            'status' => 'required|in:Active,Inactive',
        ]);

        Holiday::create($data);
        return back()->with('ok', 'Holiday added.');
    }

    public function update(Request $request, Holiday $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'hdate' => 'required|date',
            'type' => 'required|in:Public,Festival,Company,Optional',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('holidays.index')->with('ok', 'Holiday updated.');
    }

    public function destroy(Holiday $row)
    {
        $row->delete();
        return back()->with('ok', 'Holiday deleted.');
    }
}
