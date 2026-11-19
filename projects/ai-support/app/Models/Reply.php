<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['ticket_id', 'author', 'body', 'is_ai', 'approved_at', 'approved_by'];

    public function ticket()
    {
        return $this->belongsTo(\App\Models\SupportTicket::class, 'ticket_id');
    }
}
