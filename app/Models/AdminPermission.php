<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'mysql';
    protected $table = 'role_has_permissions';
    protected $guarded = ['permission_id'];
    protected $fillable = ['permission_id', 'role_id'];
}
