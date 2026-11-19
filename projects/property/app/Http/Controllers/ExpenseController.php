<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $rows = Expense::with(['property'])->latest()->get();
        return view('expenses.index', array_merge(compact('rows'), [
            'properties' => \App\Models\Property::orderBy('title')->pluck('title', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'category' => 'required|in:Repair,Utilities,Tax,Insurance,Cleaning,Other',
            'amount' => 'required|numeric|min:0',
            'exp_date' => 'required|date',
            'notes' => 'nullable|string',
            'status' => 'required|in:Paid,Pending',
        ]);

        Expense::create($data);
        return back()->with('ok', 'Expense added.');
    }

    public function update(Request $request, Expense $row)
    {
        $row->update($request->validate([
            'property_id' => 'required|exists:properties,id',
            'category' => 'required|in:Repair,Utilities,Tax,Insurance,Cleaning,Other',
            'amount' => 'required|numeric|min:0',
            'exp_date' => 'required|date',
            'notes' => 'nullable|string',
            'status' => 'required|in:Paid,Pending',
        ]));
        return redirect()->route('expenses.index')->with('ok', 'Expense updated.');
    }

    public function destroy(Expense $row)
    {
        $row->delete();
        return back()->with('ok', 'Expense deleted.');
    }
}
