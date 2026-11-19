<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $rows = Contact::latest()->get();
        return view('contacts.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'source' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        Contact::create($data);
        return back()->with('ok', 'Contact added.');
    }

    public function update(Request $request, Contact $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'source' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('contacts.index')->with('ok', 'Contact updated.');
    }

    public function destroy(Contact $row)
    {
        $row->delete();
        return back()->with('ok', 'Contact deleted.');
    }
}
