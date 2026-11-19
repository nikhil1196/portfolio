<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
    {
        $rows = MenuItem::latest()->get();
        return view('menu.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'available' => 'nullable|boolean',
        ]);

        MenuItem::create($data);
        return back()->with('ok', 'Menu Item added.');
    }

    public function update(Request $request, MenuItem $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'available' => 'nullable|boolean',
        ]));
        return redirect()->route('menu.index')->with('ok', 'Menu Item updated.');
    }

    public function destroy(MenuItem $row)
    {
        $row->delete();
        return back()->with('ok', 'Menu Item deleted.');
    }
}
