<?php

namespace Modules\Produk\App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Produk\Database\factories\KategoriFactory;

class Kategori extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'category';
    protected $guarded = ['id'];
    
    public function getIconAttribute()
    {
        return getOss('source/' . $this->attributes['icon']);
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M Y H:i');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d M Y H:i');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'type', 'name');
    }

}
