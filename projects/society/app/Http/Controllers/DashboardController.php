<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Maintenance;
use App\Models\Resident;
use App\Models\Unit;
class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'stats' => [
                'Units' => Unit::count(),
                'Residents' => Resident::count(),
                'Maintenance Due' => '₹'.number_format(Maintenance::where('status','Due')->sum('amount')),
                'Open Complaints' => Complaint::where('status','Open')->count(),
            ],
            'rows'  => Complaint::with(['resident.unit'])->where('status','!=','Resolved')->latest()->limit(8)->get(),
        ]);
    }
}
