<?php

namespace App\Http\Controllers;

use App\Models\DiningTable;
use Illuminate\Http\Request;

class DiningTableController extends Controller
{
    public function index()
    {
        $rows = DiningTable::latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('name', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('tables.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:20',
            'seats' => 'nullable|integer|min:1',
            'status' => 'required|in:Free,Occupied,Reserved',
        ]);

        DiningTable::create($data);
        return back()->with('ok', 'Table added.');
    }

    public function update(Request $request, DiningTable $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:20',
            'seats' => 'nullable|integer|min:1',
            'status' => 'required|in:Free,Occupied,Reserved',
        ]));
        return redirect()->route('tables.index')->with('ok', 'Table updated.');
    }

    public function destroy(DiningTable $row)
    {
        $row->delete();
        return back()->with('ok', 'Table deleted.');
    }
}
