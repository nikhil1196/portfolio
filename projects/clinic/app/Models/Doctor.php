<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = ['name', 'specialty', 'phone', 'email', 'fee', 'clinic_id', 'status'];

    public function clinic()
    {
        return $this->belongsTo(\App\Models\Clinic::class);
    }
}
