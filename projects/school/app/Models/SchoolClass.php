<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $fillable = ['name', 'section', 'teacher_id', 'room'];

    public function teacher()
    {
        return $this->belongsTo(\App\Models\Teacher::class);
    }

    public function students()
    {
        return $this->hasMany(\App\Models\Student::class);
    }
}
