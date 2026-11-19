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
            'members' => Member::with(['plan', 'trainer'])->when(request('q'), fn($q) => $q->where('name','like','%'.request('q').'%')->orWhere('phone','like','%'.request('q').'%')->orWhere('email','like','%'.request('q').'%'))->latest()->paginate(15)->withQueryString(),
            'plans'    => Plan::orderBy('name')->pluck('name', 'id'),
            'trainers' => Trainer::where('status', 'Active')->orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('uploads', 'public');
        }
        Member::create($data);
        return back()->with('ok', 'Member added.');
    }

    public function update(Request $request, Member $member)
    {
        $data = $this->validated($request);
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('uploads', 'public');
        }
        $member->update($data);
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
            'expiry_date' => 'nullable|date',
            'emergency_name' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:30',
            'notes'      => 'nullable|string',
            'photo'      => 'nullable|image|max:2048',
            'status'     => 'required|in:Active,Inactive,Expired',
        ]);
    }
}
