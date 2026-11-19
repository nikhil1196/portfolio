<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'stats' => [
                'Low Stock' => \App\Models\InventoryItem::whereColumn('qty','<=','reorder_level')->count(),
                'Today\'s Orders' => Order::whereDate('created_at', today())->count(),
                'Live Orders' => Order::whereIn('status', ['Pending','Preparing','Ready'])->count(),
                'Today\'s Revenue' => '₹'.number_format(Order::where('payment','Paid')->whereDate('created_at', today())->sum('total')),
                'Menu Items' => MenuItem::where('available',1)->count(),
            ],
            'rows'  => Order::with('diningTable')->whereIn('status', ['Pending','Preparing','Ready'])->orderBy('created_at')->get(),
        ]);
    }
}
