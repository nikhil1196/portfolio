<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_no', 'table_id', 'status', 'total', 'payment'];

    public function diningTable()
    {
        return $this->belongsTo(\App\Models\DiningTable::class, 'table_id');
    }

    public function items()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }
}
