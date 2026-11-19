<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use App\Models\Property;
use App\Models\Rent;
class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'stats' => [
                'Properties' => Property::count(),
                'Occupied' => Property::where('status','Occupied')->count(),
                'Active Leases' => Lease::where('status','Active')->count(),
                'Rent Due' => '₹'.number_format(Rent::where('status','Due')->sum('amount')),
            ],
            'rows'  => Rent::with(['lease.property','lease.tenant'])->where('status','Due')->latest()->limit(8)->get(),
        ]);
    }
}
