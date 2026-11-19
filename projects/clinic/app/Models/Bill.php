<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = ['invoice_no', 'patient_id', 'description', 'amount', 'status', 'paid_at'];

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }
}
