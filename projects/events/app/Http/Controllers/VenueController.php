<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index()
    {
        $rows = Venue::latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('name', 'like', "%$q%") ->orWhere('address', 'like', "%$q%"); }); }
                if (request('status')) { $rows->where('status', request('status')); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('venues.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:Active,Inactive',
        ]);

        Venue::create($data);
        return back()->with('ok', 'Venue added.');
    }

    public function update(Request $request, Venue $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('venues.index')->with('ok', 'Venue updated.');
    }

    public function destroy(Venue $row)
    {
        $row->delete();
        return back()->with('ok', 'Venue deleted.');
    }
}
