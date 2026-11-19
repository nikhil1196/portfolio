<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = ['unit_id', 'name', 'phone', 'purpose', 'check_in', 'check_out', 'status'];

    public function unit()
    {
        return $this->belongsTo(\App\Models\Unit::class);
    }
}
