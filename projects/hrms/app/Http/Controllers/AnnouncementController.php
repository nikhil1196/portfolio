<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $rows = Announcement::latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('title', 'like', "%$q%") ->orWhere('body', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('announcements.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'audience' => 'required|in:All,Management,Staff',
            'publish_date' => 'required|date',
            'status' => 'required|in:Active,Inactive',
        ]);

        Announcement::create($data);
        return back()->with('ok', 'Announcement added.');
    }

    public function update(Request $request, Announcement $row)
    {
        $row->update($request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'audience' => 'required|in:All,Management,Staff',
            'publish_date' => 'required|date',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('announcements.index')->with('ok', 'Announcement updated.');
    }

    public function destroy(Announcement $row)
    {
        $row->delete();
        return back()->with('ok', 'Announcement deleted.');
    }
}
