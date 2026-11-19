<?php
namespace App\Http\Controllers;
use App\Models\Order;
class BillController extends Controller
{
    public function show(Order $order)
    {
        return view('bill', ['o' => $order->load('items', 'diningTable')]);
    }
}