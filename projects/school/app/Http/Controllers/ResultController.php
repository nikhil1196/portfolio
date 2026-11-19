<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $rows = Result::with(['student'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('exam', 'like', "%$q%") ->orWhere('subject', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('results.index', array_merge(compact('rows'), [
            'students' => \App\Models\Student::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'exam' => 'nullable|string',
            'subject' => 'required|string',
            'marks' => 'required|numeric',
            'max_marks' => 'nullable|numeric',
            'grade' => 'nullable|string|max:5',
        ]);

        $data['grade'] = $data['grade'] ?? $this->gradeFor($data['marks'], $data['max_marks']);
        Result::create($data);
        return back()->with('ok', 'Result added.');
    }

    public function update(Request $request, Result $row)
    {
        $row->update($request->validate([
            'student_id' => 'required|exists:students,id',
            'exam' => 'nullable|string',
            'subject' => 'required|string',
            'marks' => 'required|numeric',
            'max_marks' => 'nullable|numeric',
            'grade' => 'nullable|string|max:5',
        ]));
        return redirect()->route('results.index')->with('ok', 'Result updated.');
    }

    public function destroy(Result $row)
    {
        $row->delete();
        return back()->with('ok', 'Result deleted.');
    }
    private function gradeFor(float $m, float $max): string
    {
        $p = $max > 0 ? $m / $max * 100 : 0;
        return $p >= 90 ? 'A+' : ($p >= 75 ? 'A' : ($p >= 60 ? 'B' : ($p >= 45 ? 'C' : ($p >= 33 ? 'D' : 'F'))));
    }

}
