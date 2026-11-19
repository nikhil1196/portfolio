<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index()
    {
        $rows = Visitor::with(['unit'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('name', 'like', "%$q%") ->orWhere('phone', 'like', "%$q%") ->orWhere('purpose', 'like', "%$q%"); }); }
                if (request('from')) { $rows->whereDate('check_in', '>=', request('from')); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('visitors.index', array_merge(compact('rows'), [
            'units' => \App\Models\Unit::orderBy('flat_no')->pluck('flat_no', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'purpose' => 'nullable|string',
            'check_in' => 'required|date',
            'check_out' => 'nullable|date',
            'status' => 'required|in:Inside,Left',
        ]);

        Visitor::create($data);
        return back()->with('ok', 'Visitor added.');
    }

    public function update(Request $request, Visitor $row)
    {
        $row->update($request->validate([
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'purpose' => 'nullable|string',
            'check_in' => 'required|date',
            'check_out' => 'nullable|date',
            'status' => 'required|in:Inside,Left',
        ]));
        return redirect()->route('visitors.index')->with('ok', 'Visitor updated.');
    }

    public function destroy(Visitor $row)
    {
        $row->delete();
        return back()->with('ok', 'Visitor deleted.');
    }
}
