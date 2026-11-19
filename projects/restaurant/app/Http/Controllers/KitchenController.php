<?php

namespace App\Http\Controllers;

use App\Models\Order;

class KitchenController extends Controller
{
    private const FLOW = ['Pending' => 'Preparing', 'Preparing' => 'Ready', 'Ready' => 'Served'];

    public function index()
    {
        return view('kitchen.index', [
            'columns' => [
                'Pending'   => Order::with(['diningTable', 'items'])->where('status', 'Pending')->oldest()->get(),
                'Preparing' => Order::with(['diningTable', 'items'])->where('status', 'Preparing')->oldest()->get(),
                'Ready'     => Order::with(['diningTable', 'items'])->where('status', 'Ready')->oldest()->get(),
            ],
        ]);
    }

    public function advance(Order $order)
    {
        $next = self::FLOW[$order->status] ?? null;
        if (!$next) return back();

        $order->update(['status' => $next]);
        if ($next === 'Served') $order->diningTable?->update(['status' => 'Free']);

        return back()->with('ok', "{$order->order_no} → $next");
    }
}
