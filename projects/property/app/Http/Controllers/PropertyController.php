<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $rows = Property::latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('title', 'like', "%$q%") ->orWhere('address', 'like', "%$q%") ->orWhere('city', 'like', "%$q%") ->orWhere('type', 'like', "%$q%"); }); }
                if (request('status')) { $rows->where('status', request('status')); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('properties.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'rent' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:4096',
            'status' => 'required|in:Available,Occupied,Maintenance',
        ]);

        if ($request->hasFile('image')) { $data['image'] = $request->file('image')->store('properties', 'public'); }
        Property::create($data);
        return back()->with('ok', 'Property added.');
    }

    public function update(Request $request, Property $row)
    {
        $row->update($request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'rent' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:4096',
            'status' => 'required|in:Available,Occupied,Maintenance',
        ]));
        return redirect()->route('properties.index')->with('ok', 'Property updated.');
    }

    public function destroy(Property $row)
    {
        $row->delete();
        return back()->with('ok', 'Property deleted.');
    }
}
