<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $rows = Payment::with(['appointment.patient','appointment.doctor'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('receipt_no', 'like', "%$q%") ->orWhere('txn_ref', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('payments.index', array_merge(compact('rows'), [
            'appointments' => \App\Models\Appointment::orderBy('id')->pluck('id', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|in:Cash,Card,UPI,Stripe',
            'status' => 'required|in:Paid,Pending,Refunded',
            'txn_ref' => 'nullable|string',
        ]);
        $data['receipt_no'] = 'RCP-' . str_pad((string)(\App\Models\Payment::max('id') + 1001), 4, '0', STR_PAD_LEFT);
        $payment = Payment::create($data);
        // Stripe boundary: with STRIPE_SECRET set, create a real PaymentIntent here via stripe/stripe-php.
        // Demo mode: capture the advance-booking payment with a simulated txn ref.
        if ($payment->method === 'Stripe' && !$payment->txn_ref) {
            $payment->update(['txn_ref' => 'pi_demo_' . bin2hex(random_bytes(6)), 'status' => 'Paid']);
        }
        // Email the receipt to the patient and the treating doctor.
        $appt = $payment->appointment;
        if ($appt) {
            $body = "Receipt {$payment->receipt_no}\nAmount: ₹{$payment->amount}\nMethod: {$payment->method}\nStatus: {$payment->status}\nAppointment: {$appt->appt_date} {$appt->appt_time}\nDoctor: {$appt->doctor->name}";
            foreach ([$appt->patient->email ?? null, $appt->doctor->email ?? null] as $to) {
                if ($to) { \Illuminate\Support\Facades\Mail::raw($body, fn ($m) => $m->to($to)->subject("Payment Receipt {$payment->receipt_no}")); }
            }
        }
        return back()->with('ok', 'Payment added. Receipt emailed to patient & doctor.');
    }

    public function update(Request $request, Payment $row)
    {
        $row->update($request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|in:Cash,Card,UPI,Stripe',
            'status' => 'required|in:Paid,Pending,Refunded',
            'txn_ref' => 'nullable|string',
        ]));
        return redirect()->route('payments.index')->with('ok', 'Payment updated.');
    }

    public function destroy(Payment $row)
    {
        $row->delete();
        return back()->with('ok', 'Payment deleted.');
    }
}
