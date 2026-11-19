<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GymClass extends Model
{
    protected $table = 'gym_classes';
    protected $fillable = ['name', 'trainer_id', 'day', 'start_time', 'duration_min', 'capacity', 'status'];

    public function trainer()
    {
        return $this->belongsTo(\App\Models\Trainer::class);
    }
}
