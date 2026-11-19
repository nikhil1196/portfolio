<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['employee_id', 'title', 'type', 'file_path', 'expiry', 'status'];

    public function employee()
    {
        return $this->belongsTo(\App\Models\Employee::class);
    }
}
