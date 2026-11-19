<?php
namespace App\Http\Controllers;
use App\Models\Payroll;
class PayslipController extends Controller
{
    public function show(Payroll $payroll)
    {
        return view('payslip', ['p' => $payroll->load('employee.department')]);
    }
    public function markPaid(Payroll $payroll)
    {
        $payroll->update(['status' => 'Paid', 'paid_at' => now()]);
        return back()->with('ok', 'Payroll marked paid.');
    }
}