<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['name', 'class_id', 'subject_id', 'exam_date', 'max_marks', 'status'];

    public function schoolClass()
    {
        return $this->belongsTo(\App\Models\SchoolClass::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(\App\Models\Subject::class);
    }
}
