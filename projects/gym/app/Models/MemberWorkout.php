<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberWorkout extends Model
{
    protected $table = 'member_workouts';
    protected $fillable = ['member_id', 'workout_plan_id', 'start_date', 'status'];

    public function member()
    {
        return $this->belongsTo(\App\Models\Member::class);
    }

    public function workoutPlan()
    {
        return $this->belongsTo(\App\Models\WorkoutPlan::class);
    }
}
