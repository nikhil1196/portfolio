<?php
namespace App\Http\Controllers;
use App\Models\Lease;
use Illuminate\Http\Request;
class LeaseRenewController extends Controller
{
    public function __invoke(Request $request, Lease $lease)
    {
        $months = (int) $request->input('months', 12);
        $lease->update([
            'end_date' => \Carbon\Carbon::parse($lease->end_date)->addMonths($months),
            'renewals' => $lease->renewals + 1,
            'status'   => 'Active',
        ]);
        return back()->with('ok', "Lease renewed +{$months}mo (total renewals: {$lease->renewals}).");
    }
}