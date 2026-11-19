<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $rows = Employee::with(['department'])->latest()->get();
        return view('employees.index', array_merge(compact('rows'), [
            'departments' => \App\Models\Department::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'emp_code' => 'nullable|string|max:15',
            'name' => 'required|string|max:255',
            'dept_id' => 'nullable|exists:departments,id',
            'designation' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'joining_date' => 'nullable|date',
            'salary' => 'nullable|numeric|min:0',
            'status' => 'required|in:Active,On Notice,Exited',
        ]);

        Employee::create($data);
        return back()->with('ok', 'Employee added.');
    }

    public function update(Request $request, Employee $row)
    {
        $row->update($request->validate([
            'emp_code' => 'nullable|string|max:15',
            'name' => 'required|string|max:255',
            'dept_id' => 'nullable|exists:departments,id',
            'designation' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'joining_date' => 'nullable|date',
            'salary' => 'nullable|numeric|min:0',
            'status' => 'required|in:Active,On Notice,Exited',
        ]));
        return redirect()->route('employees.index')->with('ok', 'Employee updated.');
    }

    public function destroy(Employee $row)
    {
        $row->delete();
        return back()->with('ok', 'Employee deleted.');
    }
}
