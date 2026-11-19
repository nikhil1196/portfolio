<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $rows = Tenant::latest()->get();
        return view('tenants.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'id_proof' => 'nullable|string',
            'status' => 'required|in:Active,Moved Out',
        ]);

        Tenant::create($data);
        return back()->with('ok', 'Tenant added.');
    }

    public function update(Request $request, Tenant $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'id_proof' => 'nullable|string',
            'status' => 'required|in:Active,Moved Out',
        ]));
        return redirect()->route('tenants.index')->with('ok', 'Tenant updated.');
    }

    public function destroy(Tenant $row)
    {
        $row->delete();
        return back()->with('ok', 'Tenant deleted.');
    }
}
