<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['property_id', 'category', 'amount', 'exp_date', 'notes', 'status'];

    public function property()
    {
        return $this->belongsTo(\App\Models\Property::class);
    }
}
