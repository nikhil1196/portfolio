<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['ticket_id', 'score', 'feedback', 'rated_at'];

    public function ticket()
    {
        return $this->belongsTo(\App\Models\SupportTicket::class);
    }
}
