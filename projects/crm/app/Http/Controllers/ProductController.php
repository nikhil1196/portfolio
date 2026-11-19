<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $rows = Product::latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('name', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('products.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:Active,Inactive',
        ]);

        Product::create($data);
        return back()->with('ok', 'Product added.');
    }

    public function update(Request $request, Product $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('products.index')->with('ok', 'Product updated.');
    }

    public function destroy(Product $row)
    {
        $row->delete();
        return back()->with('ok', 'Product deleted.');
    }
}
