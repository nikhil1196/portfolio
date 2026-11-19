<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = ['patient_id', 'doctor_id', 'notes', 'medicines'];

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(\App\Models\Doctor::class);
    }
}
