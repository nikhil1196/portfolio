<?php
namespace App\Http\Controllers;
use App\Models\Prescription;
class RxPrintController extends Controller
{
    public function show(Prescription $prescription)
    {
        return view('rx', ['r' => $prescription->load('patient','doctor')]);
    }
}