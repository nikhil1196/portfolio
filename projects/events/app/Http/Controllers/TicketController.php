<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $rows = Ticket::with(['event'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('name', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('tickets.index', array_merge(compact('rows'), [
            'events' => \App\Models\Event::orderBy('title')->pluck('title', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:1',
        ]);

        Ticket::create($data);
        return back()->with('ok', 'Ticket Tier added.');
    }

    public function update(Request $request, Ticket $row)
    {
        $row->update($request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:1',
        ]));
        return redirect()->route('tickets.index')->with('ok', 'Ticket Tier updated.');
    }

    public function destroy(Ticket $row)
    {
        $row->delete();
        return back()->with('ok', 'Ticket Tier deleted.');
    }
}
