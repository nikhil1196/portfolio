<?php
namespace App\Http\Controllers;
use App\Models\AuditLog;
class AuditLogController extends Controller
{
    public function index()
    {
        $rows = AuditLog::with('user')->latest()->paginate(25)->withQueryString();
        return view('audit.index', compact('rows'));
    }
}