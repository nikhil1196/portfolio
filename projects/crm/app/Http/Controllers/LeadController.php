<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        $rows = Lead::with(['contact'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('title', 'like', "%$q%") ->orWhere('owner', 'like', "%$q%") ->orWhere('notes', 'like', "%$q%"); }); }
                if (request('stage')) { $rows->where('stage', request('stage')); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('leads.index', array_merge(compact('rows'), [
            'owners' => \App\Models\User::orderBy('name')->pluck('name'),
            'contacts' => \App\Models\Contact::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'contact_id' => 'nullable|exists:contacts,id',
            'title' => 'required|string|max:255',
            'value' => 'nullable|numeric|min:0',
            'stage' => 'required|in:New,Contacted,Qualified,Proposal,Negotiation,Won,Lost',
            'owner' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Lead::create($data);
        return back()->with('ok', 'Lead added.');
    }

    public function update(Request $request, Lead $row)
    {
        $row->update($request->validate([
            'contact_id' => 'nullable|exists:contacts,id',
            'title' => 'required|string|max:255',
            'value' => 'nullable|numeric|min:0',
            'stage' => 'required|in:New,Contacted,Qualified,Proposal,Negotiation,Won,Lost',
            'owner' => 'nullable|string',
            'notes' => 'nullable|string',
        ]));
        return redirect()->route('leads.index')->with('ok', 'Lead updated.');
    }

    public function destroy(Lead $row)
    {
        $row->delete();
        return back()->with('ok', 'Lead deleted.');
    }
}
