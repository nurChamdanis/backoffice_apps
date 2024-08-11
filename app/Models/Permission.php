<?php

namespace App\Models;

namespace App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
 use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'permissions';
    protected $guarded = ['id'];
    protected $fillable = [
        'id',
        'name'
    ];
    
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M Y H:i');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d M Y H:i');
    }
}