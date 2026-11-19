<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $fillable = ['class_id', 'day', 'period', 'subject_id', 'teacher_id', 'start_time', 'end_time'];

    public function schoolClass()
    {
        return $this->belongsTo(\App\Models\SchoolClass::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(\App\Models\Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(\App\Models\Teacher::class);
    }
}
