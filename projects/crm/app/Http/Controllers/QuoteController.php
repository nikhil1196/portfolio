<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index()
    {
        $rows = Quote::with(['deal'])->latest()->get();
        return view('quotes.index', array_merge(compact('rows'), [
            'deals' => \App\Models\Deal::orderBy('title')->pluck('title', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'deal_id' => 'required|exists:deals,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'valid_until' => 'required|date',
            'status' => 'required|in:Draft,Sent,Accepted,Rejected',
        ]);
$data['quote_no'] = 'QT-' . str_pad((string)(\App\Models\Quote::max('id') + 1001), 4, '0', STR_PAD_LEFT);
        Quote::create($data);
        return back()->with('ok', 'Quote added.');
    }

    public function update(Request $request, Quote $row)
    {
        $row->update($request->validate([
            'deal_id' => 'required|exists:deals,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'valid_until' => 'required|date',
            'status' => 'required|in:Draft,Sent,Accepted,Rejected',
        ]));
        return redirect()->route('quotes.index')->with('ok', 'Quote updated.');
    }

    public function destroy(Quote $row)
    {
        $row->delete();
        return back()->with('ok', 'Quote deleted.');
    }
}
