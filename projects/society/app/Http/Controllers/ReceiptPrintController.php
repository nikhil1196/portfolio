<?php
namespace App\Http\Controllers;
use App\Models\Receipt;
class ReceiptPrintController extends Controller
{
    public function show(Receipt $receipt)
    {
        return view('receipt-print', ['r' => $receipt->load('unit')]);
    }
}