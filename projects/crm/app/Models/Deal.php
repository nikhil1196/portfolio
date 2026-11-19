<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = ['contact_id', 'title', 'value', 'stage', 'close_date', 'status', 'probability'];

    public function contact()
    {
        return $this->belongsTo(\App\Models\Contact::class);
    }
}
