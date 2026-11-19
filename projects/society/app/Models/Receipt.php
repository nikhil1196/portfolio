<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = ['maintenance_id', 'unit_id', 'amount', 'method', 'txn_ref', 'status'];

    public function maintenance()
    {
        return $this->belongsTo(\App\Models\Maintenance::class);
    }

    public function unit()
    {
        return $this->belongsTo(\App\Models\Unit::class);
    }
}
