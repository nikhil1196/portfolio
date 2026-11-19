<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index()
    {
        return view('trainers.index', ['trainers' => Trainer::withCount('members')->when(request('q'), fn($q)=>$q->where('name','like','%'.request('q').'%')->orWhere('specialty','like','%'.request('q').'%'))->orderBy('name')->paginate(15)->withQueryString()]);
    }

    public function store(Request $request)
    {
        Trainer::create($this->validated($request));
        return back()->with('ok', 'Trainer added.');
    }

    public function update(Request $request, Trainer $trainer)
    {
        $trainer->update($this->validated($request));
        return redirect()->route('trainers.index')->with('ok', 'Trainer updated.');
    }

    public function destroy(Trainer $trainer)
    {
        $trainer->delete();
        return back()->with('ok', 'Trainer deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'      => 'required|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'phone'     => 'nullable|string|max:20',
            'status'    => 'required|in:Active,Inactive',
        ]);
    }
}
