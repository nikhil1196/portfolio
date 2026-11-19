<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $rows = Category::latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('name', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('categories.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        Category::create($data);
        return back()->with('ok', 'Event Category added.');
    }

    public function update(Request $request, Category $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('categories.index')->with('ok', 'Event Category updated.');
    }

    public function destroy(Category $row)
    {
        $row->delete();
        return back()->with('ok', 'Event Category deleted.');
    }
}
