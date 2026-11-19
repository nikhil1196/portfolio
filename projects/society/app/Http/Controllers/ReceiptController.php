<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function index()
    {
        $rows = Receipt::with(['maintenance','unit'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('receipt_no', 'like', "%$q%") ->orWhere('txn_ref', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('receipts.index', array_merge(compact('rows'), [
            'maintenances' => \App\Models\Maintenance::orderBy('id')->pluck('id', 'id'),
            'units' => \App\Models\Unit::orderBy('flat_no')->pluck('flat_no', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'maintenance_id' => 'required|exists:maintenance,id',
            'unit_id' => 'required|exists:units,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|in:Online,UPI,Card,Cash,Cheque',
            'txn_ref' => 'nullable|string',
            'status' => 'required|in:Paid,Pending,Failed',
        ]);
$data['receipt_no'] = 'SR-' . str_pad((string)(\App\Models\Receipt::max('id') + 5001), 4, '0', STR_PAD_LEFT);
        Receipt::create($data);
        return back()->with('ok', 'Maintenance Receipt added.');
    }

    public function update(Request $request, Receipt $row)
    {
        $row->update($request->validate([
            'maintenance_id' => 'required|exists:maintenance,id',
            'unit_id' => 'required|exists:units,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|in:Online,UPI,Card,Cash,Cheque',
            'txn_ref' => 'nullable|string',
            'status' => 'required|in:Paid,Pending,Failed',
        ]));
        return redirect()->route('receipts.index')->with('ok', 'Maintenance Receipt updated.');
    }

    public function destroy(Receipt $row)
    {
        $row->delete();
        return back()->with('ok', 'Maintenance Receipt deleted.');
    }
}
