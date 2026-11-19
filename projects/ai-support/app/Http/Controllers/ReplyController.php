<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function index()
    {
        $rows = Reply::with(['ticket'])->latest()->get();
        return view('replies.index', array_merge(compact('rows'), [
            'support_tickets' => \App\Models\SupportTicket::orderBy('subject')->pluck('subject', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'author' => 'required|string|max:255',
            'body' => 'required|string',
            'is_ai' => 'nullable|boolean',
        ]);

        Reply::create($data);
        return back()->with('ok', 'Reply added.');
    }

    public function update(Request $request, Reply $row)
    {
        $row->update($request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'author' => 'required|string|max:255',
            'body' => 'required|string',
            'is_ai' => 'nullable|boolean',
        ]));
        return redirect()->route('replies.index')->with('ok', 'Reply updated.');
    }

    public function destroy(Reply $row)
    {
        $row->delete();
        return back()->with('ok', 'Reply deleted.');
    }
}
