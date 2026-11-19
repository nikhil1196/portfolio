<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $table = 'inventory';
    protected $fillable = ['name', 'unit', 'qty', 'reorder_level', 'supplier', 'status'];
}
