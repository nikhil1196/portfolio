<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['booking_no', 'event_id', 'name', 'email', 'seats', 'amount', 'status', 'ticket_id','payment','txn_ref'];

    public function event()
    {
        return $this->belongsTo(\App\Models\Event::class);
    }

    public function attendees()
    {
        return $this->hasMany(\App\Models\Attendee::class);
    }
    public function ticket() { return $this->belongsTo(Ticket::class); }

}
