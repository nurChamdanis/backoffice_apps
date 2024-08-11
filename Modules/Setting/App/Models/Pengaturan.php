<?php

namespace Modules\Setting\App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Setting\Database\factories\PengaturanFactory;

class Pengaturan extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'settings';
    protected $guarded = ['id'];
    protected $casts = [
        'value'  => 'json',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
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
