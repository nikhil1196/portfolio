<?php
namespace App\Http\Controllers;
use Illuminate\Support\Str;
class RecordController extends Controller
{
    private array $map = [
        'tickets' => \App\Models\SupportTicket::class, 'replies' => \App\Models\Reply::class,
        'kb' => \App\Models\KbArticle::class, 'canned' => \App\Models\CannedReply::class,
        'agents' => \App\Models\Agent::class, 'customers' => \App\Models\Customer::class,
        'ratings' => \App\Models\Rating::class,
    ];
    public function show(string $module, int $id)
    {
        abort_unless(isset($this->map[$module]), 404);
        $r = $this->map[$module]::findOrFail($id);
        $title = Str::title(str_replace('-', ' ', Str::singular($module))) . ' #' . $id;
        return view('record', compact('r', 'title', 'module'));
    }
}