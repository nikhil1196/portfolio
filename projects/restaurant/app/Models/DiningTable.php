<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiningTable extends Model
{
    protected $table = 'tables';

    protected $fillable = ['name', 'seats', 'status'];

    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class, 'table_id');
    }
}
