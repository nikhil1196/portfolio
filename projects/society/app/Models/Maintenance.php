<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = ['unit_id', 'month', 'amount', 'status', 'paid_at'];

    public function unit()
    {
        return $this->belongsTo(\App\Models\Unit::class);
    }
}
