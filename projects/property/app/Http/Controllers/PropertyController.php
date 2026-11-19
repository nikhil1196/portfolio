<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $rows = Property::latest()->get();
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
            'status' => 'required|in:Available,Occupied,Maintenance',
        ]);

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
