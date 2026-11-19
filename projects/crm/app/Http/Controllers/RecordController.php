<?php
namespace App\Http\Controllers;
use Illuminate\Support\Str;
class RecordController extends Controller
{
    private array $map = [
        'contacts' => \App\Models\Contact::class, 'leads' => \App\Models\Lead::class,
        'deals' => \App\Models\Deal::class, 'tasks' => \App\Models\Task::class,
        'activities' => \App\Models\Activity::class, 'products' => \App\Models\Product::class,
        'quotes' => \App\Models\Quote::class,
    ];
    public function show(string $module, int $id)
    {
        abort_unless(isset($this->map[$module]), 404);
        $r = $this->map[$module]::findOrFail($id);
        $title = Str::title(str_replace('-', ' ', Str::singular($module))) . ' #' . $id;
        return view('record', compact('r', 'title', 'module'));
    }
}