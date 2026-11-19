<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    protected $table = 'requests';

    protected $fillable = ['property_id', 'tenant_id', 'category', 'subject', 'status'];

    public function property()
    {
        return $this->belongsTo(\App\Models\Property::class);
    }

    public function tenant()
    {
        return $this->belongsTo(\App\Models\Tenant::class);
    }
}
