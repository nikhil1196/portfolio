<?php
namespace App\Http\Controllers;
use App\Models\Quote;
class QuotePrintController extends Controller
{
    public function show(Quote $quote)
    {
        return view('quote-print', ['q' => $quote->load('deal.contact')]);
    }
}