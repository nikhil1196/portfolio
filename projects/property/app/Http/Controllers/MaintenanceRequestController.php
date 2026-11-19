<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;

class MaintenanceRequestController extends Controller
{
    public function index()
    {
        $rows = MaintenanceRequest::with(['property','tenant'])->latest()->get();
        return view('requests.index', array_merge(compact('rows'), [
            'properties' => \App\Models\Property::orderBy('title')->pluck('title', 'id'),
            'tenants' => \App\Models\Tenant::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'tenant_id' => 'nullable|exists:tenants,id',
            'category' => 'nullable|string',
            'subject' => 'required|string',
            'status' => 'required|in:Open,In Progress,Resolved',
        ]);

        MaintenanceRequest::create($data);
        return back()->with('ok', 'Maintenance Request added.');
    }

    public function update(Request $request, MaintenanceRequest $row)
    {
        $row->update($request->validate([
            'property_id' => 'required|exists:properties,id',
            'tenant_id' => 'nullable|exists:tenants,id',
            'category' => 'nullable|string',
            'subject' => 'required|string',
            'status' => 'required|in:Open,In Progress,Resolved',
        ]));
        return redirect()->route('requests.index')->with('ok', 'Maintenance Request updated.');
    }

    public function destroy(MaintenanceRequest $row)
    {
        $row->delete();
        return back()->with('ok', 'Maintenance Request deleted.');
    }
}
