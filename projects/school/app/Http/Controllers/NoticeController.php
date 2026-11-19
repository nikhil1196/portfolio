<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $rows = Notice::latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('title', 'like', "%$q%") ->orWhere('body', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('notices.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'audience' => 'required|in:All,Students,Teachers,Parents',
            'publish_on' => 'nullable|date',
            'status' => 'required|in:Published,Draft',
        ]);

        Notice::create($data);
        return back()->with('ok', 'Notice added.');
    }

    public function update(Request $request, Notice $row)
    {
        $row->update($request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'audience' => 'required|in:All,Students,Teachers,Parents',
            'publish_on' => 'nullable|date',
            'status' => 'required|in:Published,Draft',
        ]));
        return redirect()->route('notices.index')->with('ok', 'Notice updated.');
    }

    public function destroy(Notice $row)
    {
        $row->delete();
        return back()->with('ok', 'Notice deleted.');
    }
}
