<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Fee;
use App\Models\Student;
use App\Models\Teacher;
class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'stats' => [
                'Students' => Student::where('status','Active')->count(),
                'Teachers' => Teacher::count(),
                'Classes' => SchoolClass::count(),
                'Fees Collected' => '₹'.number_format(Fee::where('status','Paid')->sum('amount')),
            ],
            'rows'  => Student::with('schoolClass')->latest()->limit(8)->get(),
        ]);
    }
}
