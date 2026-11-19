<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = ['resident_id', 'category', 'subject', 'description', 'status', 'assigned_to', 'resolution', 'resolved_at'];

    public function resident()
    {
        return $this->belongsTo(\App\Models\Resident::class);
    }
}
