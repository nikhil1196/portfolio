<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = ['contact_id', 'title', 'value', 'stage', 'owner', 'notes'];

    public function contact()
    {
        return $this->belongsTo(\App\Models\Contact::class);
    }
}
