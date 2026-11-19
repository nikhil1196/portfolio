<?php
namespace App\Http\Controllers;
use App\Models\Activity;
class ActivityDoneController extends Controller
{
    public function __invoke(Activity $activity)
    {
        $activity->update(['done' => !$activity->done]);
        return back()->with('ok', 'Activity ' . ($activity->done ? 'completed' : 'reopened') . '.');
    }
}