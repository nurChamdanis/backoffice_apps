<?php

namespace Modules\Users\App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Users\Database\factories\BannerFactory;

class Banner extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'banners';
    protected $guarded = ['id'];
    
    public function getImageAttribute()
    {
        return getOss('source/' . $this->attributes['image']);
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M Y H:i');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d M Y H:i');
    }
}
