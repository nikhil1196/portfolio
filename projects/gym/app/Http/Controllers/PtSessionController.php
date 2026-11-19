<?php

namespace App\Http\Controllers;

use App\Models\PtSession;
use Illuminate\Http\Request;

class PtSessionController extends Controller
{
    public function index()
    {
        $rows = PtSession::with(['member','trainer'])->latest()->get();
        return view('pt-sessions.index', array_merge(compact('rows'), [
            'members' => \App\Models\Member::orderBy('name')->pluck('name', 'id'),
            'trainers' => \App\Models\Trainer::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id' => 'required|exists:members,id',
            'trainer_id' => 'required|exists:trainers,id',
            'session_date' => 'required|date',
            'start_time' => 'nullable',
            'duration_min' => 'nullable|integer',
            'focus' => 'nullable|string',
            'status' => 'required|in:Scheduled,Completed,Cancelled',
        ]);

        PtSession::create($data);
        return back()->with('ok', 'PT Session added.');
    }

    public function update(Request $request, PtSession $row)
    {
        $row->update($request->validate([
            'member_id' => 'required|exists:members,id',
            'trainer_id' => 'required|exists:trainers,id',
            'session_date' => 'required|date',
            'start_time' => 'nullable',
            'duration_min' => 'nullable|integer',
            'focus' => 'nullable|string',
            'status' => 'required|in:Scheduled,Completed,Cancelled',
        ]));
        return redirect()->route('pt-sessions.index')->with('ok', 'PT Session updated.');
    }

    public function destroy(PtSession $row)
    {
        $row->delete();
        return back()->with('ok', 'PT Session deleted.');
    }
}
