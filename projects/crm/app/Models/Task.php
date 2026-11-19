<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['contact_id', 'title', 'due_date', 'priority', 'status'];

    public function contact()
    {
        return $this->belongsTo(\App\Models\Contact::class);
    }
}
