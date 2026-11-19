<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrAttendance extends Model
{
    protected $table = 'attendances';

    protected $fillable = ['emp_id', 'work_date', 'check_in', 'status'];

    public function employee()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'emp_id');
    }
}
