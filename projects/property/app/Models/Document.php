<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['property_id', 'tenant_id', 'title', 'type', 'file_path', 'status'];

    public function property()
    {
        return $this->belongsTo(\App\Models\Property::class);
    }

    public function tenant()
    {
        return $this->belongsTo(\App\Models\Tenant::class);
    }
}
