<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['emp_code', 'name', 'dept_id', 'designation', 'email', 'phone', 'joining_date', 'salary', 'status'];

    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class, 'dept_id');
    }
}
