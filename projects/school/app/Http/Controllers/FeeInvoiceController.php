<?php
namespace App\Http\Controllers;
use App\Models\Fee;
class FeeInvoiceController extends Controller
{
    public function show(Fee $fee)
    {
        return view('invoice', ['f' => $fee->load('student.schoolClass')]);
    }
}