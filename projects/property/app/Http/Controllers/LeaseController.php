<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use Illuminate\Http\Request;

class LeaseController extends Controller
{
    public function index()
    {
        $rows = Lease::with(['property','tenant'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('status', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('leases.index', array_merge(compact('rows'), [
            'properties' => \App\Models\Property::orderBy('title')->pluck('title', 'id'),
            'tenants' => \App\Models\Tenant::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'tenant_id' => 'required|exists:tenants,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'rent' => 'required|numeric|min:0',
            'deposit' => 'nullable|numeric|min:0',
            'status' => 'required|in:Active,Expired,Terminated',
        ]);

        Lease::create($data);
        return back()->with('ok', 'Lease added.');
    }

    public function update(Request $request, Lease $row)
    {
        $row->update($request->validate([
            'property_id' => 'required|exists:properties,id',
            'tenant_id' => 'required|exists:tenants,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'rent' => 'required|numeric|min:0',
            'deposit' => 'nullable|numeric|min:0',
            'status' => 'required|in:Active,Expired,Terminated',
        ]));
        return redirect()->route('leases.index')->with('ok', 'Lease updated.');
    }

    public function destroy(Lease $row)
    {
        $row->delete();
        return back()->with('ok', 'Lease deleted.');
    }
}
