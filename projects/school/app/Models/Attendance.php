<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['student_id', 'att_date', 'status', 'remark'];

    public function student()
    {
        return $this->belongsTo(\App\Models\Student::class);
    }
}
