<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CannedReply extends Model
{
    protected $table = 'canned_replies';

    protected $fillable = ['title', 'body', 'category'];
}
