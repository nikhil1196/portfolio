<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = ['resident_id', 'category', 'subject', 'description', 'status'];

    public function resident()
    {
        return $this->belongsTo(\App\Models\Resident::class);
    }
}
