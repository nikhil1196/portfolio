<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    protected $table = 'parking';
    protected $fillable = ['slot_no', 'unit_id', 'vehicle_no', 'vehicle_type', 'status'];

    public function unit()
    {
        return $this->belongsTo(\App\Models\Unit::class);
    }
}
