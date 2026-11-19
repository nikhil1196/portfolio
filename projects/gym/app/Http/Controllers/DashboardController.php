<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Member;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalMembers'  => Member::count(),
            'activeMembers' => Member::where('status', 'Active')->count(),
            'monthRevenue'  => Payment::where('status', 'Paid')
                ->whereMonth('paid_at', now()->month)
                ->whereYear('paid_at', now()->year)->sum('amount'),
            'todayCheckins' => Attendance::whereDate('check_in', today())->count(),
            'recentMembers' => Member::with('plan')->latest()->limit(6)->get(),
            'inGym'         => Attendance::with('member')->whereNull('check_out')
                ->latest('check_in')->get(),
        ]);
    }
}
