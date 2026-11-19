<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function index()
    {
        $rows = Clinic::latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->where('name', 'like', "%$q%")->orWhere('city', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('clinics.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:Active,Inactive',
        ]);

        Clinic::create($data);
        return back()->with('ok', 'Clinic Branch added.');
    }

    public function update(Request $request, Clinic $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('clinics.index')->with('ok', 'Clinic Branch updated.');
    }

    public function destroy(Clinic $row)
    {
        $row->delete();
        return back()->with('ok', 'Clinic Branch deleted.');
    }
}
