<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = ['title', 'subject_id', 'class_id', 'teacher_id', 'due_date', 'description', 'status'];

    public function subject()
    {
        return $this->belongsTo(\App\Models\Subject::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(\App\Models\SchoolClass::class, 'class_id');
    }

    public function teacher()
    {
        return $this->belongsTo(\App\Models\Teacher::class);
    }
}
