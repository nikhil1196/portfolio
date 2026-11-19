<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        $rows = Document::with(['employee'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('title', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('documents.index', array_merge(compact('rows'), [
            'employees' => \App\Models\Employee::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:ID Proof,Contract,Certificate,Offer Letter,Other',
            'file_path' => 'nullable|string',
            'expiry' => 'nullable|date',
            'status' => 'required|in:Active,Expired',
        ]);

        Document::create($data);
        return back()->with('ok', 'Employee Document added.');
    }

    public function update(Request $request, Document $row)
    {
        $row->update($request->validate([
            'employee_id' => 'required|exists:employees,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:ID Proof,Contract,Certificate,Offer Letter,Other',
            'file_path' => 'nullable|string',
            'expiry' => 'nullable|date',
            'status' => 'required|in:Active,Expired',
        ]));
        return redirect()->route('documents.index')->with('ok', 'Employee Document updated.');
    }

    public function destroy(Document $row)
    {
        $row->delete();
        return back()->with('ok', 'Employee Document deleted.');
    }
}
