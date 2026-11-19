<?php
namespace App\Http\Controllers;
use App\Models\Payment;
class ReceiptController extends Controller
{
    public function show(Payment $payment)
    {
        return view('receipt', ['p' => $payment->load('appointment.patient','appointment.doctor')]);
    }
}