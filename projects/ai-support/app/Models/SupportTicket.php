<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $table = 'tickets';

    protected $fillable = ['ticket_no', 'customer', 'email', 'subject', 'channel', 'priority', 'status', 'agent_id', 'ai_summary', 'customer_id'];

    public function agent()
    {
        return $this->belongsTo(\App\Models\Agent::class);
    }

    public function replies()
    {
        return $this->hasMany(\App\Models\Reply::class, 'ticket_id');
    }
    public function customerRef() { return $this->belongsTo(Customer::class, 'customer_id'); }

}
