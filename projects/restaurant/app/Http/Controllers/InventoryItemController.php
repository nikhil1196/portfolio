<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    public function index()
    {
        $rows = InventoryItem::latest()->get();
        return view('inventory.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|in:kg,g,ltr,ml,pcs,box',
            'qty' => 'required|numeric|min:0',
            'reorder_level' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        InventoryItem::create($data);
        return back()->with('ok', 'Inventory Item added.');
    }

    public function update(Request $request, InventoryItem $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|in:kg,g,ltr,ml,pcs,box',
            'qty' => 'required|numeric|min:0',
            'reorder_level' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('inventory.index')->with('ok', 'Inventory Item updated.');
    }

    public function destroy(InventoryItem $row)
    {
        $row->delete();
        return back()->with('ok', 'Inventory Item deleted.');
    }
}
