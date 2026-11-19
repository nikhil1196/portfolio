<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'plan_id', 'trainer_id', 'join_date', 'status', 'emergency_name', 'emergency_phone', 'photo', 'expiry_date', 'notes'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
