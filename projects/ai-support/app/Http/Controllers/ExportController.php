<?php
namespace App\Http\Controllers;
class ExportController extends Controller
{
    private array $map = [
        'tickets' => \App\Models\SupportTicket::class, 'replies' => \App\Models\Reply::class,
        'kb' => \App\Models\KbArticle::class, 'canned' => \App\Models\CannedReply::class,
        'agents' => \App\Models\Agent::class, 'customers' => \App\Models\Customer::class,
        'ratings' => \App\Models\Rating::class,
    ];
    public function csv(string $module)
    {
        abort_unless(isset($this->map[$module]), 404);
        $rows = $this->map[$module]::all();
        $name = $module . '-' . now()->format('Ymd') . '.csv';
        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            if ($rows->isNotEmpty()) {
                fputcsv($out, array_keys($rows->first()->getAttributes()));
                foreach ($rows as $r) fputcsv($out, $r->getAttributes());
            }
            fclose($out);
        }, $name, ['Content-Type' => 'text/csv']);
    }
}