<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $rows = Customer::latest()->get();
        return view('customers.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'company' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        Customer::create($data);
        return back()->with('ok', 'Customer added.');
    }

    public function update(Request $request, Customer $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'company' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('customers.index')->with('ok', 'Customer updated.');
    }

    public function destroy(Customer $row)
    {
        $row->delete();
        return back()->with('ok', 'Customer deleted.');
    }
}
