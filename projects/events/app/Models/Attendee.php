<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    protected $fillable = ['booking_id', 'name', 'checked_in'];

    public function booking()
    {
        return $this->belongsTo(\App\Models\Booking::class);
    }
}
