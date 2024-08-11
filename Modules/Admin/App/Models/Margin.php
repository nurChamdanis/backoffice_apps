<?php

namespace Modules\Admin\App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\factories\MarginFactory;
use Modules\Produk\App\Models\Produk;

class Margin extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'margins';
    protected $guarded = ['id'];

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M Y H:i');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d M Y H:i');
    }

    public function produk()
    {
        return $this->hasOne(Produk::class,  'code', 'produk_id');
    }
}
