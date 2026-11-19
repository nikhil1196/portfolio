<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'roll_no', 'class_id', 'guardian', 'phone', 'dob', 'status', 'parent_email', 'document'];

    public function schoolClass()
    {
        return $this->belongsTo(\App\Models\SchoolClass::class, 'class_id');
    }
    public function fees() { return $this->hasMany(Fee::class); }
    public function results() { return $this->hasMany(Result::class); }
    public function attendances() { return $this->hasMany(Attendance::class); }

}
