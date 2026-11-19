<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index()
    {
        $rows = SupportTicket::with(['agent'])->latest()->get();
        return view('tickets.index', array_merge(compact('rows'), [
            'agents' => \App\Models\Agent::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer' => 'required|string|max:255',
            'email' => 'nullable|email',
            'subject' => 'required|string|max:255',
            'channel' => 'required|in:Email,Chat,WhatsApp,Phone,API',
            'priority' => 'required|in:High,Medium,Low',
            'status' => 'required|in:Open,In Progress,Resolved',
            'agent_id' => 'nullable|exists:agents,id',
            'ai_summary' => 'nullable|string',
        ]);
        $data['ticket_no'] = 'TCK-' . str_pad((string)(\App\Models\SupportTicket::max('id') + 9001), 4, '0', STR_PAD_LEFT);
        SupportTicket::create($data);
        return back()->with('ok', 'Ticket added.');
    }

    public function update(Request $request, SupportTicket $row)
    {
        $row->update($request->validate([
            'customer' => 'required|string|max:255',
            'email' => 'nullable|email',
            'subject' => 'required|string|max:255',
            'channel' => 'required|in:Email,Chat,WhatsApp,Phone,API',
            'priority' => 'required|in:High,Medium,Low',
            'status' => 'required|in:Open,In Progress,Resolved',
            'agent_id' => 'nullable|exists:agents,id',
            'ai_summary' => 'nullable|string',
        ]));
        return redirect()->route('tickets.index')->with('ok', 'Ticket updated.');
    }

    public function destroy(SupportTicket $row)
    {
        $row->delete();
        return back()->with('ok', 'Ticket deleted.');
    }
}
