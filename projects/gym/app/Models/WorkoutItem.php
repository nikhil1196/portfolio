<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutItem extends Model
{
    protected $table = 'workout_items';
    protected $fillable = ['workout_plan_id', 'exercise_id', 'day', 'sets', 'reps'];

    public function workoutPlan()
    {
        return $this->belongsTo(\App\Models\WorkoutPlan::class);
    }

    public function exercise()
    {
        return $this->belongsTo(\App\Models\Exercise::class);
    }
}
