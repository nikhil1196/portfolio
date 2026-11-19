<?php
namespace App\Http\Controllers;
use Illuminate\Support\Str;
class RecordController extends Controller
{
    private array $map = [
        'properties' => \App\Models\Property::class, 'tenants' => \App\Models\Tenant::class,
        'leases' => \App\Models\Lease::class, 'rents' => \App\Models\Rent::class,
        'requests' => \App\Models\MaintenanceRequest::class, 'expenses' => \App\Models\Expense::class,
        'documents' => \App\Models\Document::class,
    ];
    public function show(string $module, int $id)
    {
        abort_unless(isset($this->map[$module]), 404);
        $r = $this->map[$module]::findOrFail($id);
        $title = Str::title(str_replace('-', ' ', Str::singular($module))) . ' #' . $id;
        return view('record', compact('r', 'title', 'module'));
    }
}