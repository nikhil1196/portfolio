<?php

namespace App\Http\Controllers;

use App\Models\DiningTable;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        return view('pos.index', [
            'items'  => MenuItem::where('available', 1)->orderBy('category')->orderBy('name')->get()->groupBy('category'),
            'tables' => DiningTable::where('status', 'Free')->orderBy('name')->get(),
            'orders' => Order::with('diningTable')->latest()->limit(25)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(['table_id' => 'required|exists:tables,id']);

        $lines = [];
        $total = 0;
        foreach ($request->input('qty', []) as $itemId => $qty) {
            $qty = (int) $qty;
            if ($qty <= 0) continue;
            $item = MenuItem::find($itemId);
            if (!$item) continue;
            $lines[] = ['item_name' => $item->name, 'qty' => $qty, 'price' => $item->price];
            $total += $qty * $item->price;
        }

        if (!$lines) return back()->with('ok', 'Select at least one item.');

        $order = Order::create([
            'order_no' => 'ORD-' . str_pad((string) (Order::max('id') + 1001), 4, '0', STR_PAD_LEFT),
            'table_id' => $request->table_id,
            'status'   => 'Pending',
            'total'    => $total,
        ]);
        foreach ($lines as $l) $order->items()->create($l);
        DiningTable::where('id', $request->table_id)->update(['status' => 'Occupied']);

        return back()->with('ok', "Order {$order->order_no} sent to kitchen.");
    }

    public function settle(Order $order)
    {
        $order->update(['payment' => 'Paid', 'status' => 'Served']);
        $order->diningTable?->update(['status' => 'Free']);
        return back()->with('ok', 'Payment settled — ' . $order->order_no);
    }
}
