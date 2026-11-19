<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $rows = Event::latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('title', 'like', "%$q%") ->orWhere('category', 'like', "%$q%") ->orWhere('venue', 'like', "%$q%") ->orWhere('organizer', 'like', "%$q%"); }); }
                if (request('status')) { $rows->where('status', request('status')); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('events.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string',
            'venue' => 'nullable|string',
            'organizer' => 'nullable|string|max:120',
            'organizer_contact' => 'nullable|string|max:120',
            'event_date' => 'required|date',
            'price' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:0',
            'status' => 'required|in:Published,Draft,Cancelled',
        ]);

        if (!empty($data['venue']) && \App\Models\Event::where('venue', $data['venue'])->whereDate('event_date', \Carbon\Carbon::parse($data['event_date'])->toDateString())->exists()) {
            return back()->withInput()->with('error', "Venue '{$data['venue']}' already has an event that day — pick another venue or date.");
        }
        Event::create($data);
        return back()->with('ok', 'Event added.');
    }

    public function update(Request $request, Event $row)
    {
        $row->update($request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string',
            'venue' => 'nullable|string',
            'organizer' => 'nullable|string|max:120',
            'organizer_contact' => 'nullable|string|max:120',
            'event_date' => 'required|date',
            'price' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:0',
            'status' => 'required|in:Published,Draft,Cancelled',
        ]));
        return redirect()->route('events.index')->with('ok', 'Event updated.');
    }

    public function destroy(Event $row)
    {
        $row->delete();
        return back()->with('ok', 'Event deleted.');
    }
}
