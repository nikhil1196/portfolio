<?php
namespace App\Http\Controllers;
use App\Models\FeeStructure;
use Illuminate\Http\Request;
class FeeStructureController extends Controller
{
    public function index()
    {
        $rows = FeeStructure::with('schoolClass')->latest();
        if ($q = request('q')) { $rows->where('term', 'like', "%$q%"); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('fee-structures.index', array_merge(compact('rows'), [
            'school_classes' => \App\Models\SchoolClass::orderBy('name')->pluck('name', 'id'),
        ]));
    }
    public function store(Request $request)
    {
        FeeStructure::create($request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'term' => 'required|string|max:60',
            'amount' => 'required|numeric|min:0',
        ]));
        return back()->with('ok', 'Fee structure added.');
    }
    public function update(Request $request, $id)
    {
        FeeStructure::findOrFail($id)->update($request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'term' => 'required|string|max:60',
            'amount' => 'required|numeric|min:0',
        ]));
        return back()->with('ok', 'Fee structure updated.');
    }
    public function destroy($id)
    {
        FeeStructure::findOrFail($id)->delete();
        return back()->with('ok', 'Fee structure deleted.');
    }
}