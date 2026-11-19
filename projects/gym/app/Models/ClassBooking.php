<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassBooking extends Model
{
    protected $table = 'class_bookings';
    protected $fillable = ['gym_class_id', 'member_id', 'booking_date', 'status'];

    public function gymClass()
    {
        return $this->belongsTo(\App\Models\GymClass::class, 'gym_class_id');
    }

    public function member()
    {
        return $this->belongsTo(\App\Models\Member::class);
    }
}
