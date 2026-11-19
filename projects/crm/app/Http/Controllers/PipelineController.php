<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;

class PipelineController extends Controller
{
    public const STAGES = ['Qualification', 'Proposal', 'Negotiation', 'Won', 'Lost'];

    public function index()
    {
        $deals = Deal::with('contact')->latest()->get()->groupBy('stage');
        return view('pipeline.index', [
            'stages' => self::STAGES,
            'deals'  => $deals,
            'totalOpen' => Deal::where('status', 'Open')->sum('value'),
        ]);
    }

    public function move(Deal $row, Request $request)
    {
        $data = $request->validate(['stage' => 'required|in:' . implode(',', self::STAGES)]);
        $row->update([
            'stage'  => $data['stage'],
            'status' => in_array($data['stage'], ['Won', 'Lost']) ? 'Closed' : 'Open',
        ]);
        return back()->with('ok', "Deal moved to {$data['stage']}.");
    }
}
