<?php
namespace App\Http\Controllers;
use App\Models\MenuItem;
class MenuToggleController extends Controller
{
    public function __invoke(MenuItem $item)
    {
        $item->update(['available' => !$item->available]);
        return back()->with('ok', $item->name . ' is now ' . ($item->available ? 'Available' : 'Unavailable'));
    }
}