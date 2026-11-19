<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $rows = Complaint::with(['resident.unit'])->latest()->get();
        return view('complaints.index', array_merge(compact('rows'), [
            'residents' => \App\Models\Resident::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'category' => 'nullable|string',
            'subject' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:Open,In Progress,Resolved',
        ]);

        Complaint::create($data);
        return back()->with('ok', 'Complaint added.');
    }

    public function update(Request $request, Complaint $row)
    {
        $row->update($request->validate([
            'resident_id' => 'required|exists:residents,id',
            'category' => 'nullable|string',
            'subject' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:Open,In Progress,Resolved',
        ]));
        return redirect()->route('complaints.index')->with('ok', 'Complaint updated.');
    }

    public function destroy(Complaint $row)
    {
        $row->delete();
        return back()->with('ok', 'Complaint deleted.');
    }

    public function setStatus(Complaint $row, Request $request)
    {
        $data = $request->validate(["status" => "required|in:Open,In Progress,Resolved"]);
        $row->update($data);
        return back()->with("ok", "Complaint marked {$data["status"]}.");
    }
}