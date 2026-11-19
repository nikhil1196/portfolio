<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    protected $fillable = ['booking_id', 'name', 'checked_in', 'checkin_code'];

    public function booking()
    {
        return $this->belongsTo(\App\Models\Booking::class);
    }
    protected static function booted(): void
    {
        static::creating(function ($a) {
            $a->checkin_code ??= strtoupper(\Illuminate\Support\Str::random(8));
        });
    }

}
