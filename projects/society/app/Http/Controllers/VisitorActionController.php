<?php
namespace App\Http\Controllers;
use App\Models\Visitor;
class VisitorActionController extends Controller
{
    public function approve(Visitor $visitor)
    {
        $visitor->update(['approved_by' => auth()->user()->name ?? 'admin']);
        return back()->with('ok', 'Visitor approved.');
    }
    public function checkout(Visitor $visitor)
    {
        $visitor->update(['check_out' => now(), 'status' => 'Left']);
        return back()->with('ok', 'Visitor checked out.');
    }
}