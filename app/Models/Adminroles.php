<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adminroles extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'roles';
    protected $guarded = ['id'];
    protected $fillable = ['name', 'guard_name'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    
}
