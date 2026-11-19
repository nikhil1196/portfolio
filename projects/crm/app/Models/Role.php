<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Role extends Model
{
    protected $fillable = ['name', 'perms'];
    public function users() { return $this->hasMany(User::class); }
    public function permsList(): array { return array_filter(array_map('trim', explode(',', (string)$this->perms))); }
}
