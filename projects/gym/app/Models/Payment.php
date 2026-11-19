<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['invoice_no', 'member_id', 'plan_id', 'amount', 'method', 'status', 'paid_at'];

    protected $casts = ['paid_at' => 'date'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
