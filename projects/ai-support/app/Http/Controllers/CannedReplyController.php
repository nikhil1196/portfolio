<?php

namespace App\Http\Controllers;

use App\Models\CannedReply;
use Illuminate\Http\Request;

class CannedReplyController extends Controller
{
    public function index()
    {
        $rows = CannedReply::latest()->get();
        return view('canned.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category' => 'nullable|string',
        ]);

        CannedReply::create($data);
        return back()->with('ok', 'Canned Reply added.');
    }

    public function update(Request $request, CannedReply $row)
    {
        $row->update($request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category' => 'nullable|string',
        ]));
        return redirect()->route('canned.index')->with('ok', 'Canned Reply updated.');
    }

    public function destroy(CannedReply $row)
    {
        $row->delete();
        return back()->with('ok', 'Canned Reply deleted.');
    }
}
