<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = ['quote_no', 'deal_id', 'title', 'amount', 'valid_until', 'status'];

    public function deal()
    {
        return $this->belongsTo(\App\Models\Deal::class);
    }
}
