<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    protected $fillable = ['unit_id', 'name', 'phone', 'email', 'role', 'status'];

    public function unit()
    {
        return $this->belongsTo(\App\Models\Unit::class);
    }

    public function complaints()
    {
        return $this->hasMany(\App\Models\Complaint::class);
    }
}
