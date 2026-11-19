<?php

namespace App\Http\Controllers;

use App\Models\KbArticle;
use Illuminate\Http\Request;

class KbArticleController extends Controller
{
    public function index()
    {
        $rows = KbArticle::latest()->get();
        return view('kb.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string',
            'body' => 'required|string',
            'views' => 'nullable|integer',
            'status' => 'required|in:Published,Draft',
        ]);

        KbArticle::create($data);
        return back()->with('ok', 'KB Article added.');
    }

    public function update(Request $request, KbArticle $row)
    {
        $row->update($request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string',
            'body' => 'required|string',
            'views' => 'nullable|integer',
            'status' => 'required|in:Published,Draft',
        ]));
        return redirect()->route('kb.index')->with('ok', 'KB Article updated.');
    }

    public function destroy(KbArticle $row)
    {
        $row->delete();
        return back()->with('ok', 'KB Article deleted.');
    }
}
