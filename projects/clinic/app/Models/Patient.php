<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['name', 'phone', 'dob', 'gender', 'blood', 'address', 'status'];
}
