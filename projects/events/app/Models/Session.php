<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'event_sessions';
    protected $fillable = ['event_id', 'title', 'speaker', 'starts_at', 'ends_at', 'room', 'status'];

    public function event()
    {
        return $this->belongsTo(\App\Models\Event::class);
    }
}
