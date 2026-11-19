<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;

class DealController extends Controller
{
    public function index()
    {
        $rows = Deal::with(['contact'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('title', 'like', "%$q%"); }); }
                if (request('stage')) { $rows->where('stage', request('stage')); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('deals.index', array_merge(compact('rows'), [
            'contacts' => \App\Models\Contact::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'title' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
            'stage' => 'required|in:Qualification,Proposal,Negotiation,Won,Lost',
            'close_date' => 'nullable|date',
            'probability' => 'nullable|integer|min:0|max:100',
            'status' => 'required|in:Open,Closed',
        ]);

        Deal::create($data);
        return back()->with('ok', 'Deal added.');
    }

    public function update(Request $request, Deal $row)
    {
        $row->update($request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'title' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
            'stage' => 'required|in:Qualification,Proposal,Negotiation,Won,Lost',
            'close_date' => 'nullable|date',
            'probability' => 'nullable|integer|min:0|max:100',
            'status' => 'required|in:Open,Closed',
        ]));
        return redirect()->route('deals.index')->with('ok', 'Deal updated.');
    }

    public function destroy(Deal $row)
    {
        $row->delete();
        return back()->with('ok', 'Deal deleted.');
    }
}
