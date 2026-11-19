<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    protected $fillable = ['member_id', 'measured_on', 'weight_kg', 'height_cm', 'chest_cm', 'waist_cm', 'arms_cm', 'body_fat', 'notes'];

    public function member()
    {
        return $this->belongsTo(\App\Models\Member::class);
    }
}
