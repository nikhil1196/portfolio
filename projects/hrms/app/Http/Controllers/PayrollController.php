<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $rows = Payroll::with(['employee'])->latest()->get();
        return view('payroll.index', array_merge(compact('rows'), [
            'employees' => \App\Models\Employee::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'emp_id' => 'required|exists:employees,id',
            'month' => 'required|string|max:10',
            'basic' => 'required|numeric',
            'allowances' => 'nullable|numeric',
            'deductions' => 'nullable|numeric',
            'status' => 'required|in:Processed,Paid,On Hold',
        ]);
        $data['net'] = ($data['basic'] ?? 0) + ($data['allowances'] ?? 0) - ($data['deductions'] ?? 0);
        Payroll::create($data);
        return back()->with('ok', 'Payroll Entry added.');
    }

    public function update(Request $request, Payroll $row)
    {
        $row->update($request->validate([
            'emp_id' => 'required|exists:employees,id',
            'month' => 'required|string|max:10',
            'basic' => 'required|numeric',
            'allowances' => 'nullable|numeric',
            'deductions' => 'nullable|numeric',
            'status' => 'required|in:Processed,Paid,On Hold',
        ]));
        return redirect()->route('payroll.index')->with('ok', 'Payroll Entry updated.');
    }

    public function destroy(Payroll $row)
    {
        $row->delete();
        return back()->with('ok', 'Payroll Entry deleted.');
    }
}
