<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;

class RentController extends Controller
{
    public function index()
    {
        $rows = Rent::with(['lease.property','lease.tenant'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('month', 'like', "%$q%") ->orWhere('status', 'like', "%$q%"); }); }
                if (request('status')) { $rows->where('status', request('status')); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('rents.index', array_merge(compact('rows'), [
            'leases' => \App\Models\Lease::orderBy('id')->pluck('id', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lease_id' => 'required|exists:leases,id',
            'month' => 'required|string|max:10',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:Paid,Due,Overdue',
            'paid_at' => 'nullable|date',
        ]);

        Rent::create($data);
        return back()->with('ok', 'Rent Record added.');
    }

    public function update(Request $request, Rent $row)
    {
        $row->update($request->validate([
            'lease_id' => 'required|exists:leases,id',
            'month' => 'required|string|max:10',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:Paid,Due,Overdue',
            'paid_at' => 'nullable|date',
        ]));
        return redirect()->route('rents.index')->with('ok', 'Rent Record updated.');
    }

    public function destroy(Rent $row)
    {
        $row->delete();
        return back()->with('ok', 'Rent Record deleted.');
    }
}
