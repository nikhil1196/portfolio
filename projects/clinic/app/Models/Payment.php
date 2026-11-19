<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['appointment_id', 'amount', 'method', 'status', 'receipt_no', 'txn_ref'];

    public function appointment()
    {
        return $this->belongsTo(\App\Models\Appointment::class);
    }
}
