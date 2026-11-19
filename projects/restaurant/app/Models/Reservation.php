<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['table_id', 'name', 'phone', 'guests', 'res_date', 'res_time', 'status'];

    public function table()
    {
        return $this->belongsTo(\App\Models\DiningTable::class, 'table_id');
    }
}
