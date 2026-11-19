<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['student_id', 'exam', 'subject', 'marks', 'max_marks', 'grade'];

    public function student()
    {
        return $this->belongsTo(\App\Models\Student::class);
    }
}
