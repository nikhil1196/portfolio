<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index()
    {
        $rows = SupportTicket::with(['agent'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('ticket_no', 'like', "%$q%") ->orWhere('customer', 'like', "%$q%") ->orWhere('subject', 'like', "%$q%") ->orWhere('channel', 'like', "%$q%"); }); }
                if (request('status')) { $rows->where('status', request('status')); }
        if (request('priority')) { $rows->where('priority', request('priority')); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('tickets.index', array_merge(compact('rows'), [
            'customers' => \App\Models\Customer::orderBy('name')->pluck('name', 'id'),
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
            'customer_id' => 'nullable|exists:customers,id',
            'ai_summary' => 'nullable|string',
        ]);
        $data['ticket_no'] = 'TCK-' . str_pad((string)(\App\Models\SupportTicket::max('id') + 9001), 4, '0', STR_PAD_LEFT);
        if (!empty($data['customer_id'])) {
            $cu = \App\Models\Customer::find($data['customer_id']);
            if ($cu) { $data['customer'] = $cu->name; $data['email'] ??= $cu->email; }
        }
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
            'customer_id' => 'nullable|exists:customers,id',
            'ai_summary' => 'nullable|string',
        ]));
        return redirect()->route('tickets.index')->with('ok', 'Ticket updated.');
    }

    public function destroy(SupportTicket $row)
    {
        $row->delete();
        return back()->with('ok', 'Ticket deleted.');
    }

    public function suggest(SupportTicket $row)
    {
        // Keyword-match the ticket subject against published KB articles
        $words = array_filter(preg_split("/[^a-zA-Z0-9]+/", strtolower($row->subject)), fn($w) => strlen($w) > 2);
        $best = null; $score = 0;
        foreach (\App\Models\KbArticle::where("status", "Published")->get() as $kb) {
            $s = 0;
            $hay = strtolower($kb->title . " " . $kb->body);
            foreach ($words as $w) { if (str_contains($hay, $w)) $s++; }
            if ($s > $score) { $score = $s; $best = $kb; }
        }
        if ($best) {
            $body = "Based on our knowledge base ({$best->title}): " . $best->body;
            $summary = "AI matched KB article: {$best->title} (score {$score})";
        } else {
            $body = "Thank you for reaching out. I have logged your request regarding \"{$row->subject}\" and routed it to the right team. You will hear back within 24 hours.";
            $summary = "AI: no KB match — generic acknowledgement drafted";
        }
        \App\Models\Reply::create([
            "ticket_id" => $row->id, "author" => "Support Bot", "body" => $body, "is_ai" => 1,
        ]);
        $row->update(["ai_summary" => $summary, "status" => $row->status === "Open" ? "In Progress" : $row->status]);
        return back()->with("ok", "AI draft reply created from " . ($best ? "KB match" : "fallback") . ".");
    }
}