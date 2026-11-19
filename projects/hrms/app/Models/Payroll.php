<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = ['emp_id', 'month', 'basic', 'allowances', 'deductions', 'net', 'status'];

    public function employee()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'emp_id');
    }
}
