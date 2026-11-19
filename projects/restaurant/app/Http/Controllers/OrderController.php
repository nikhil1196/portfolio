<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $rows = Order::with(['diningTable','items'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('order_no', 'like', "%$q%") ->orWhere('status', 'like', "%$q%"); }); }
                if (request('status')) { $rows->where('status', request('status')); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('orders.index', array_merge(compact('rows'), [
            'dining_tables' => \App\Models\DiningTable::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'table_id' => 'nullable|exists:tables,id',
            'status' => 'required|in:Pending,Preparing,Ready,Served',
            'total' => 'nullable|numeric|min:0',
            'payment' => 'required|in:Paid,Unpaid',
        ]);

        Order::create($data);
        return back()->with('ok', 'Order added.');
    }

    public function update(Request $request, Order $row)
    {
        $row->update($request->validate([
            'table_id' => 'nullable|exists:tables,id',
            'status' => 'required|in:Pending,Preparing,Ready,Served',
            'total' => 'nullable|numeric|min:0',
            'payment' => 'required|in:Paid,Unpaid',
        ]));
        return redirect()->route('orders.index')->with('ok', 'Order updated.');
    }

    public function destroy(Order $row)
    {
        $row->delete();
        return back()->with('ok', 'Order deleted.');
    }
}
