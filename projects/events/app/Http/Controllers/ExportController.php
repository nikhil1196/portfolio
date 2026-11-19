<?php
namespace App\Http\Controllers;
class ExportController extends Controller
{
    private array $map = [
        'events' => \App\Models\Event::class, 'categories' => \App\Models\Category::class,
        'venues' => \App\Models\Venue::class, 'sessions' => \App\Models\Session::class,
        'tickets' => \App\Models\Ticket::class, 'bookings' => \App\Models\Booking::class,
        'attendees' => \App\Models\Attendee::class,
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