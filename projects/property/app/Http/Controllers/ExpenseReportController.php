<?php
namespace App\Http\Controllers;
use App\Models\Expense;
class ExpenseReportController extends Controller
{
    public function index()
    {
        $year = request('year', now()->year);
        $byCat = Expense::whereYear('exp_date', $year)->selectRaw('category, SUM(amount) as total, COUNT(*) as n')->groupBy('category')->orderByDesc('total')->get();
        $byMonth = Expense::whereYear('exp_date', $year)->selectRaw("strftime('%m', exp_date) as m, SUM(amount) as total")->groupBy('m')->orderBy('m')->pluck('total', 'm');
        return view('expense-report', compact('byCat', 'byMonth', 'year'));
    }
}