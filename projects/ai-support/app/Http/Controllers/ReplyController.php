<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function index()
    {
        $rows = Reply::with(['ticket'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('author', 'like', "%$q%") ->orWhere('body', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
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

        if (empty($data['is_ai'])) { $data['approved_at'] = now(); $data['approved_by'] = auth()->id(); }
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
    public function approve(\App\Models\Reply $reply)
    {
        $reply->update(['approved_at' => now(), 'approved_by' => auth()->id()]);
        return back()->with('ok', 'Reply approved.');
    }

}
