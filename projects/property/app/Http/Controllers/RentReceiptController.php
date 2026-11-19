<?php
namespace App\Http\Controllers;
use App\Models\Rent;
class RentReceiptController extends Controller
{
    public function show(Rent $rent)
    {
        return view('rent-receipt', ['r' => $rent->load('lease.tenant', 'lease.property')]);
    }
    public function markPaid(Rent $rent)
    {
        $rent->update(['status' => 'Paid', 'paid_at' => now()]);
        return back()->with('ok', 'Rent marked paid.');
    }
}