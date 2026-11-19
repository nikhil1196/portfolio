<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $fillable = ['name', 'specialty', 'phone', 'status', 'availability'];

    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
