<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KbArticle extends Model
{
    protected $table = 'kb_articles';

    protected $fillable = ['title', 'category', 'body', 'views', 'status'];
}
