<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['doctor_id', 'clinic_id', 'day', 'start_time', 'end_time', 'slot_min', 'status'];

    public function doctor()
    {
        return $this->belongsTo(\App\Models\Doctor::class);
    }

    public function clinic()
    {
        return $this->belongsTo(\App\Models\Clinic::class);
    }
}
