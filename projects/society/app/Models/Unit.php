<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['block', 'flat_no', 'floor', 'type', 'area_sqft', 'status', 'owner_name', 'owner_phone'];
}
