<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $fillable = ['receipt_no', 'student_id', 'term', 'amount', 'status', 'paid_at'];

    public function student()
    {
        return $this->belongsTo(\App\Models\Student::class);
    }
}
