<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['amenity', 'unit_id', 'booking_date', 'slot', 'status'];

    public function unit()
    {
        return $this->belongsTo(\App\Models\Unit::class);
    }
}
