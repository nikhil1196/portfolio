<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $rows = Booking::with(['event'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('booking_no', 'like', "%$q%") ->orWhere('name', 'like', "%$q%") ->orWhere('email', 'like', "%$q%"); }); }
                if (request('status')) { $rows->where('status', request('status')); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('bookings.index', array_merge(compact('rows'), [
            'tickets' => \App\Models\Ticket::with('event')->get()->mapWithKeys(fn($t) => [$t->id => $t->event->title . ' — ' . $t->name . ' (' . max(0, $t->qty - $t->sold) . ' left)']),
            'events' => \App\Models\Event::orderBy('title')->pluck('title', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'seats' => 'required|integer|min:1',
            'amount' => 'nullable|numeric|min:0',
            'ticket_id' => 'nullable|exists:tickets,id',
            'payment' => 'nullable|in:Unpaid,Paid,Refunded', 'txn_ref' => 'nullable|string|max:120',
            'status' => 'required|in:Confirmed,Cancelled,Refunded',
        ]);
        $data['booking_no'] = 'BKG-' . str_pad((string)(\App\Models\Booking::max('id') + 5001), 4, '0', STR_PAD_LEFT);
        if (!empty($data['ticket_id'])) {
            $t = \App\Models\Ticket::findOrFail($data['ticket_id']);
            if ($t->event_id != $data['event_id']) return back()->withInput()->with('error', 'Ticket tier does not belong to that event.');
            if ($t->sold + $data['seats'] > $t->qty) return back()->withInput()->with('error', "Only " . max(0, $t->qty - $t->sold) . " seats left on {$t->name}.");
            $t->increment('sold', $data['seats']);
        }
        Booking::create($data);
        return back()->with('ok', 'Booking added.');
    }

    public function update(Request $request, Booking $row)
    {
        $row->update($request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'seats' => 'required|integer|min:1',
            'amount' => 'nullable|numeric|min:0',
            'ticket_id' => 'nullable|exists:tickets,id',
            'payment' => 'nullable|in:Unpaid,Paid,Refunded', 'txn_ref' => 'nullable|string|max:120',
            'status' => 'required|in:Confirmed,Cancelled,Refunded',
        ]));
        return redirect()->route('bookings.index')->with('ok', 'Booking updated.');
    }

    public function destroy(Booking $row)
    {
        $row->delete();
        return back()->with('ok', 'Booking deleted.');
    }
}
