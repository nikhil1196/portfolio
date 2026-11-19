<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Deal;
use App\Models\Lead;
use App\Models\Task;
class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'stats' => [
                'Contacts' => Contact::count(),
                'Open Leads' => Lead::whereNotIn('stage', ['Won','Lost'])->count(),
                'Pipeline Value' => '₹'.number_format(Deal::where('status','Open')->sum('value')),
                'Deals Won' => '₹'.number_format(Deal::where('stage','Won')->sum('value')),
            ],
            'rows'  => Task::with('contact')->where('status','Open')->orderBy('due_date')->limit(8)->get(),
        ]);
    }
}
