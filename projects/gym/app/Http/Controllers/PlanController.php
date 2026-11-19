<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        return view('plans.index', ['plans' => Plan::withCount('members')->orderBy('price')->get()]);
    }

    public function store(Request $request)
    {
        Plan::create($this->validated($request));
        return back()->with('ok', 'Plan added.');
    }

    public function update(Request $request, Plan $plan)
    {
        $plan->update($this->validated($request));
        return redirect()->route('plans.index')->with('ok', 'Plan updated.');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return back()->with('ok', 'Plan deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'            => 'required|string|max:255',
            'duration_months' => 'required|integer|min:1',
            'price'           => 'required|numeric|min:0',
            'features'        => 'nullable|string|max:255',
            'status'          => 'required|in:Active,Inactive',
        ]);
    }
}
