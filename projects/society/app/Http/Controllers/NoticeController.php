<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $rows = Notice::latest()->get();
        return view('notices.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'audience' => 'required|in:All,Owners,Tenants',
            'published_at' => 'nullable|date',
        ]);

        Notice::create($data);
        return back()->with('ok', 'Notice added.');
    }

    public function update(Request $request, Notice $row)
    {
        $row->update($request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'audience' => 'required|in:All,Owners,Tenants',
            'published_at' => 'nullable|date',
        ]));
        return redirect()->route('notices.index')->with('ok', 'Notice updated.');
    }

    public function destroy(Notice $row)
    {
        $row->delete();
        return back()->with('ok', 'Notice deleted.');
    }
}
