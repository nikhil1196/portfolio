<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        $rows = Rating::with(['ticket'])->latest()->get();
        return view('ratings.index', array_merge(compact('rows'), [
            'support_tickets' => \App\Models\SupportTicket::orderBy('subject')->pluck('subject', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'score' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string',
            'rated_at' => 'required|date',
        ]);

        Rating::create($data);
        return back()->with('ok', 'Satisfaction Rating added.');
    }

    public function update(Request $request, Rating $row)
    {
        $row->update($request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'score' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string',
            'rated_at' => 'required|date',
        ]));
        return redirect()->route('ratings.index')->with('ok', 'Satisfaction Rating updated.');
    }

    public function destroy(Rating $row)
    {
        $row->delete();
        return back()->with('ok', 'Satisfaction Rating deleted.');
    }
}
