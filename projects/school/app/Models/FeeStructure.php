<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class FeeStructure extends Model
{
    protected $fillable = ['class_id','term','amount'];
    public function schoolClass() { return $this->belongsTo(SchoolClass::class, 'class_id'); }
}