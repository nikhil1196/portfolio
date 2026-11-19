<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index()
    {
        $rows = Bill::with(['patient'])->latest()->get();
        return view('bills.index', array_merge(compact('rows'), [
            'patients' => \App\Models\Patient::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:Paid,Pending,Cancelled',
            'paid_at' => 'nullable|date',
        ]);
        $data['invoice_no'] = 'BILL-' . str_pad((string)(\App\Models\Bill::max('id') + 1001), 4, '0', STR_PAD_LEFT);
        Bill::create($data);
        return back()->with('ok', 'Bill added.');
    }

    public function update(Request $request, Bill $row)
    {
        $row->update($request->validate([
            'patient_id' => 'required|exists:patients,id',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:Paid,Pending,Cancelled',
            'paid_at' => 'nullable|date',
        ]));
        return redirect()->route('bills.index')->with('ok', 'Bill updated.');
    }

    public function destroy(Bill $row)
    {
        $row->delete();
        return back()->with('ok', 'Bill deleted.');
    }
}
