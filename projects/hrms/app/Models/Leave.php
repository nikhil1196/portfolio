<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = ['emp_id', 'type', 'from_date', 'to_date', 'reason', 'status'];

    public function employee()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'emp_id');
    }
}
