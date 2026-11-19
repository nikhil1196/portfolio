<?php
namespace App\Http\Controllers;
class ExportController extends Controller
{
    private array $map = [
        'units' => \App\Models\Unit::class, 'residents' => \App\Models\Resident::class,
        'maintenance' => \App\Models\Maintenance::class, 'complaints' => \App\Models\Complaint::class,
        'notices' => \App\Models\Notice::class, 'bookings' => \App\Models\Booking::class,
        'receipts' => \App\Models\Receipt::class, 'visitors' => \App\Models\Visitor::class,
        'staff' => \App\Models\Staff::class, 'parking' => \App\Models\Parking::class,
        'members' => \App\Models\FamilyMember::class,
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