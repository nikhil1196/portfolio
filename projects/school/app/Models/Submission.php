<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = ['assignment_id', 'student_id', 'submitted_at', 'notes', 'marks', 'status'];

    public function assignment()
    {
        return $this->belongsTo(\App\Models\Assignment::class);
    }

    public function student()
    {
        return $this->belongsTo(\App\Models\Student::class);
    }
}
