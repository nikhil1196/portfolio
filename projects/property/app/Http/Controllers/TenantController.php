<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $rows = Tenant::latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('name', 'like', "%$q%") ->orWhere('phone', 'like', "%$q%") ->orWhere('email', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
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
            'document' => 'nullable|file|max:4096',
            'status' => 'required|in:Active,Moved Out',
        ]);

        if ($request->hasFile('document')) { $data['document'] = $request->file('document')->store('docs', 'public'); }
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
            'document' => 'nullable|file|max:4096',
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
