<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Payment;
use App\Models\Plan;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payments.index', [
            'payments'  => Payment::with(['member', 'plan'])->latest()->limit(60)->get(),
            'totalPaid' => Payment::where('status', 'Paid')->sum('amount'),
            'members'   => Member::orderBy('name')->pluck('name', 'id'),
            'plans'     => Plan::where('status', 'Active')->orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id' => 'required|exists:members,id',
            'plan_id'   => 'nullable|exists:plans,id',
            'amount'    => 'required|numeric|min:0',
            'method'    => 'required|in:Cash,UPI,Card,Bank Transfer',
            'status'    => 'required|in:Paid,Pending,Due',
        ]);

        $data['invoice_no'] = 'INV-' . str_pad((string) (Payment::max('id') + 1001), 4, '0', STR_PAD_LEFT);
        $data['paid_at']    = today();

        Payment::create($data);
        return back()->with('ok', 'Payment recorded — ' . $data['invoice_no']);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return back()->with('ok', 'Payment deleted.');
    }

    public function markPaid(Payment $payment)
    {
        $payment->update(["status" => "Paid", "paid_at" => now()]);
        return back()->with("ok", "Payment marked as paid.");
    }
}