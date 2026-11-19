<?php
namespace App\Http\Controllers;
use App\Models\Complaint;
class ComplaintActionController extends Controller
{
    public function start(Complaint $complaint)
    {
        $complaint->update(['status' => 'In Progress']);
        return back()->with('ok', 'Complaint started.');
    }
    public function resolve(Complaint $complaint)
    {
        $complaint->update(['status' => 'Resolved', 'resolved_at' => now()]);
        return back()->with('ok', 'Complaint resolved.');
    }
}