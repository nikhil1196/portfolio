<?php
namespace App\Http\Controllers;
use Illuminate\Support\Str;
class RecordController extends Controller
{
    private array $map = [
        'menu' => \App\Models\MenuItem::class, 'categories' => \App\Models\Category::class,
        'tables' => \App\Models\DiningTable::class, 'orders' => \App\Models\Order::class,
        'reservations' => \App\Models\Reservation::class, 'inventory' => \App\Models\InventoryItem::class,
    ];
    public function show(string $module, int $id)
    {
        abort_unless(isset($this->map[$module]), 404);
        $r = $this->map[$module]::findOrFail($id);
        $title = Str::title(str_replace('-', ' ', Str::singular($module))) . ' #' . $id;
        return view('record', compact('r', 'title', 'module'));
    }
}