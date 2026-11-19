<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PtSession extends Model
{
    protected $table = 'pt_sessions';
    protected $fillable = ['member_id', 'trainer_id', 'session_date', 'start_time', 'duration_min', 'focus', 'status'];

    public function member()
    {
        return $this->belongsTo(\App\Models\Member::class);
    }

    public function trainer()
    {
        return $this->belongsTo(\App\Models\Trainer::class);
    }
}
