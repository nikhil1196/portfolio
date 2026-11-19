<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    protected $fillable = ['lease_id', 'month', 'amount', 'status', 'paid_at'];

    public function lease()
    {
        return $this->belongsTo(\App\Models\Lease::class);
    }
}
