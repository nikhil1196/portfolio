<?php
namespace App\Http\Controllers;
class ExportController extends Controller
{
    private array $map = [
        'menu' => \App\Models\MenuItem::class, 'categories' => \App\Models\Category::class,
        'tables' => \App\Models\DiningTable::class, 'orders' => \App\Models\Order::class,
        'reservations' => \App\Models\Reservation::class, 'inventory' => \App\Models\InventoryItem::class,
        'stock-movements' => \App\Models\StockMovement::class,
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