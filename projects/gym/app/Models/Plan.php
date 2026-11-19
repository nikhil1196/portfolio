<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['name', 'duration_months', 'price', 'features', 'status'];

    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
