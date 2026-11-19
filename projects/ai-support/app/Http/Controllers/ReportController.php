<?php
namespace App\Http\Controllers;
class ReportController extends Controller
{
    public function index()
    {
        $sections = [
        ['tickets', \App\Models\SupportTicket::class],
        ['replies', \App\Models\Reply::class],
        ['kb', \App\Models\KbArticle::class],
        ['canned', \App\Models\CannedReply::class],
        ['agents', \App\Models\Agent::class],
        ];
        $reports = [];
        foreach ($sections as [$uri, $model]) {
            $byStatus = [];
            try {
                $byStatus = $model::selectRaw('status, COUNT(*) as c')->groupBy('status')->pluck('c', 'status')->toArray();
            } catch (\Throwable $e) {}
            $reports[] = [
                'uri' => $uri, 'title' => ucfirst($uri),
                'total' => $model::count(),
                'month' => $model::where('created_at', '>=', now()->startOfMonth())->count(),
                'byStatus' => $byStatus,
            ];
        }
        return view('reports.index', compact('reports'));
    }
}
