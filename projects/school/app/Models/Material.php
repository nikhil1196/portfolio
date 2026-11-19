<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['title', 'subject_id', 'class_id', 'type', 'url', 'status'];

    public function subject()
    {
        return $this->belongsTo(\App\Models\Subject::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(\App\Models\SchoolClass::class, 'class_id');
    }
}
