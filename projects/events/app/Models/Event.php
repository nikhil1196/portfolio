<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'category', 'venue', 'event_date', 'price', 'capacity', 'status', 'organizer', 'organizer_contact'];
}
