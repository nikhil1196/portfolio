<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Bill;
use App\Models\Doctor;
use App\Models\Patient;
class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'stats' => [
                'Patients' => Patient::count(),
                'Doctors' => Doctor::count(),
                'Today\'s Appointments' => Appointment::whereDate('appt_date', today())->count(),
                'Revenue (Month)' => '₹'.number_format(Bill::where('status','Paid')->whereMonth('paid_at', now()->month)->whereYear('paid_at', now()->year)->sum('amount')),
            ],
            'rows'  => Appointment::with(['patient','doctor'])->whereDate('appt_date', today())->orderBy('appt_time')->get(),
        ]);
    }
}
