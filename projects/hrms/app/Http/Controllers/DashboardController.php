<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\HrAttendance;
use App\Models\Leave;
class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'stats' => [
                'Employees' => Employee::where('status','Active')->count(),
                'Departments' => Department::count(),
                'Present Today' => HrAttendance::whereDate('work_date', today())->where('status','Present')->count(),
                'Pending Leaves' => Leave::where('status','Pending')->count(),
            ],
            'rows'  => HrAttendance::with('employee')->whereDate('work_date', today())->get(),
        ]);
    }
}
