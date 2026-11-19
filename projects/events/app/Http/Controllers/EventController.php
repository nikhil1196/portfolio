<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $rows = Event::latest()->get();
        return view('events.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string',
            'venue' => 'nullable|string',
            'event_date' => 'required|date',
            'price' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:0',
            'status' => 'required|in:Published,Draft,Cancelled',
        ]);

        Event::create($data);
        return back()->with('ok', 'Event added.');
    }

    public function update(Request $request, Event $row)
    {
        $row->update($request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string',
            'venue' => 'nullable|string',
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
