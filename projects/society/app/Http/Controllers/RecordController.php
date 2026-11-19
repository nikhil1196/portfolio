<?php
namespace App\Http\Controllers;
use Illuminate\Support\Str;
class RecordController extends Controller
{
    private array $map = [
        'units' => \App\Models\Unit::class, 'residents' => \App\Models\Resident::class,
        'maintenance' => \App\Models\Maintenance::class, 'complaints' => \App\Models\Complaint::class,
        'notices' => \App\Models\Notice::class, 'bookings' => \App\Models\Booking::class,
        'receipts' => \App\Models\Receipt::class, 'visitors' => \App\Models\Visitor::class,
        'staff' => \App\Models\Staff::class, 'parking' => \App\Models\Parking::class,
        'members' => \App\Models\FamilyMember::class,
    ];
    public function show(string $module, int $id)
    {
        abort_unless(isset($this->map[$module]), 404);
        $r = $this->map[$module]::findOrFail($id);
        $title = Str::title(str_replace('-', ' ', Str::singular($module))) . ' #' . $id;
        return view('record', compact('r', 'title', 'module'));
    }
}