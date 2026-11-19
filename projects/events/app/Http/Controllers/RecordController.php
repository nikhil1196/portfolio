<?php
namespace App\Http\Controllers;
use Illuminate\Support\Str;
class RecordController extends Controller
{
    private array $map = [
        'events' => \App\Models\Event::class, 'categories' => \App\Models\Category::class,
        'venues' => \App\Models\Venue::class, 'sessions' => \App\Models\Session::class,
        'tickets' => \App\Models\Ticket::class, 'bookings' => \App\Models\Booking::class,
        'attendees' => \App\Models\Attendee::class,
    ];
    public function show(string $module, int $id)
    {
        abort_unless(isset($this->map[$module]), 404);
        $r = $this->map[$module]::findOrFail($id);
        $title = Str::title(str_replace('-', ' ', Str::singular($module))) . ' #' . $id;
        return view('record', compact('r', 'title', 'module'));
    }
}