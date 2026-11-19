<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        $rows = Session::with(['event'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('title', 'like', "%$q%") ->orWhere('speaker', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('sessions.index', array_merge(compact('rows'), [
            'events' => \App\Models\Event::orderBy('title')->pluck('title', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'required|exists:events,id',
            'title' => 'required|string|max:255',
            'speaker' => 'nullable|string',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date',
            'room' => 'nullable|string',
            'status' => 'required|in:Scheduled,Live,Done',
        ]);

        Session::create($data);
        return back()->with('ok', 'Session / Speaker added.');
    }

    public function update(Request $request, Session $row)
    {
        $row->update($request->validate([
            'event_id' => 'required|exists:events,id',
            'title' => 'required|string|max:255',
            'speaker' => 'nullable|string',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date',
            'room' => 'nullable|string',
            'status' => 'required|in:Scheduled,Live,Done',
        ]));
        return redirect()->route('sessions.index')->with('ok', 'Session / Speaker updated.');
    }

    public function destroy(Session $row)
    {
        $row->delete();
        return back()->with('ok', 'Session / Speaker deleted.');
    }
}
