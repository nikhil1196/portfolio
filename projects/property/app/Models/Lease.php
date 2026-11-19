<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{
    protected $fillable = ['property_id', 'tenant_id', 'start_date', 'end_date', 'rent', 'deposit', 'status'];

    public function property()
    {
        return $this->belongsTo(\App\Models\Property::class);
    }

    public function tenant()
    {
        return $this->belongsTo(\App\Models\Tenant::class);
    }
}
