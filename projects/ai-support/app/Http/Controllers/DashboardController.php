<?php

namespace App\Http\Controllers;

use App\Models\KbArticle;
use App\Models\Reply;
use App\Models\SupportTicket;
class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'stats' => [
                'Open Tickets' => SupportTicket::where('status','Open')->count(),
                'In Progress' => SupportTicket::where('status','In Progress')->count(),
                'AI Replies' => Reply::where('is_ai',1)->count(),
                'KB Articles' => KbArticle::where('status','Published')->count(),
            ],
            'rows'  => SupportTicket::with('agent')->where('status','!=','Resolved')->latest()->limit(8)->get(),
        ]);
    }
}
