<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index()
    {
        $rows = Agent::latest()->get();
        return view('agents.index', array_merge(compact('rows'), [
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'role' => 'required|in:Agent,Team Lead,AI Assistant',
            'status' => 'required|in:Active,Inactive',
        ]);

        Agent::create($data);
        return back()->with('ok', 'Agent added.');
    }

    public function update(Request $request, Agent $row)
    {
        $row->update($request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'role' => 'required|in:Agent,Team Lead,AI Assistant',
            'status' => 'required|in:Active,Inactive',
        ]));
        return redirect()->route('agents.index')->with('ok', 'Agent updated.');
    }

    public function destroy(Agent $row)
    {
        $row->delete();
        return back()->with('ok', 'Agent deleted.');
    }
}
