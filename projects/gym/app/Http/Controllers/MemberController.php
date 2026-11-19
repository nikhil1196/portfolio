<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Plan;
use App\Models\Trainer;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        return view('members.index', [
            'members' => Member::with(['plan', 'trainer'])->latest()->get(),
            'plans'    => Plan::orderBy('name')->pluck('name', 'id'),
            'trainers' => Trainer::where('status', 'Active')->orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        Member::create($this->validated($request));
        return back()->with('ok', 'Member added.');
    }

    public function update(Request $request, Member $member)
    {
        $member->update($this->validated($request));
        return redirect()->route('members.index')->with('ok', 'Member updated.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return back()->with('ok', 'Member deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'nullable|email',
            'phone'      => 'nullable|string|max:20',
            'plan_id'    => 'nullable|exists:plans,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'join_date'  => 'nullable|date',
            'status'     => 'required|in:Active,Inactive,Expired',
        ]);
    }
}
