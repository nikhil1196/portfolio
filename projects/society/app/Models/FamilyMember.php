<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    protected $table = 'family_members';
    protected $fillable = ['unit_id', 'resident_id', 'name', 'relation', 'phone', 'occupation', 'status'];

    public function unit()
    {
        return $this->belongsTo(\App\Models\Unit::class);
    }

    public function resident()
    {
        return $this->belongsTo(\App\Models\Resident::class);
    }
}
