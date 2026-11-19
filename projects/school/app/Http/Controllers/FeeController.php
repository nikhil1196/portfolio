<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        $rows = Fee::with(['student'])->latest()->get();
        return view('fees.index', array_merge(compact('rows'), [
            'students' => \App\Models\Student::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'term' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:Paid,Pending,Overdue',
            'paid_at' => 'nullable|date',
        ]);
        $data['receipt_no'] = 'RCP-' . str_pad((string)(\App\Models\Fee::max('id') + 2001), 4, '0', STR_PAD_LEFT);
        Fee::create($data);
        return back()->with('ok', 'Fee added.');
    }

    public function update(Request $request, Fee $row)
    {
        $row->update($request->validate([
            'student_id' => 'required|exists:students,id',
            'term' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:Paid,Pending,Overdue',
            'paid_at' => 'nullable|date',
        ]));
        return redirect()->route('fees.index')->with('ok', 'Fee updated.');
    }

    public function destroy(Fee $row)
    {
        $row->delete();
        return back()->with('ok', 'Fee deleted.');
    }

    public function markPaid(Fee $row)
    {
        $row->update(["status" => "Paid", "paid_at" => now()->toDateString()]);
        return back()->with("ok", "Fee marked as paid.");
    }
}