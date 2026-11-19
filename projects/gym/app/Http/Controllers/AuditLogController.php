<?php
namespace App\Http\Controllers;
use App\Models\AuditLog;
class AuditLogController extends Controller
{
    public function index()
    {
        $rows = AuditLog::with('user')->latest();
        if ($q = request('q')) {
            $rows->where(fn($w) => $w->where('summary', 'like', "%$q%")->orWhere('model_type', 'like', "%$q%")->orWhere('action', 'like', "%$q%"));
        }
        if (request('from')) { $rows->whereDate('created_at', '>=', request('from')); }
        if (request('to')) { $rows->whereDate('created_at', '<=', request('to')); }
        $rows = $rows->paginate(25)->withQueryString();
        return view('audit.index', compact('rows'));
    }
}