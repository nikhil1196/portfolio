<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['lead_id', 'type', 'summary', 'due_at', 'done'];

    public function lead()
    {
        return $this->belongsTo(\App\Models\Lead::class);
    }
}
