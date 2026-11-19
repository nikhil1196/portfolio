<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        $rows = Document::with(['property','tenant'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('title', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('documents.index', array_merge(compact('rows'), [
            'properties' => \App\Models\Property::orderBy('title')->pluck('title', 'id'),
            'tenants' => \App\Models\Tenant::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'tenant_id' => 'nullable|exists:tenants,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:Agreement,ID Proof,Invoice,Notice,Other',
            'file_path' => 'nullable|string',
            'status' => 'required|in:Active,Archived',
        ]);

        Document::create($data);
        return back()->with('ok', 'Document added.');
    }

    public function update(Request $request, Document $row)
    {
        $row->update($request->validate([
            'property_id' => 'required|exists:properties,id',
            'tenant_id' => 'nullable|exists:tenants,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:Agreement,ID Proof,Invoice,Notice,Other',
            'file_path' => 'nullable|string',
            'status' => 'required|in:Active,Archived',
        ]));
        return redirect()->route('documents.index')->with('ok', 'Document updated.');
    }

    public function destroy(Document $row)
    {
        $row->delete();
        return back()->with('ok', 'Document deleted.');
    }
}
