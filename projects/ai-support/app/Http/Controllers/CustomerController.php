<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $rows = Customer::latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('name', 'like', "%$q%") ->orWhere('email', 'like', "%$q%") ->orWhere('company', 'like', "%$q%") ->orWhere('phone', 'like', "%$q%"); }); }
                if (request('status')) { $rows->where('status', request('status')); }
        if (request('priority')) { $rows->where('priority', request('priority')); }
        $rows = $rows->paginate(15)->withQueryString();
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
