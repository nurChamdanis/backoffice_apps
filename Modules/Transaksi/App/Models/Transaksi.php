<?php

namespace Modules\Transaksi\App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Produk\App\Models\Produk;
use Modules\Transaksi\Database\factories\TransaksiFactory;

class Transaksi extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $connection = 'mysql';
    protected $table = 'transactions';
    protected $guarded = ['id'];

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M Y H:i');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d M Y H:i');
    }

    /**
     * Get the user that owns the Transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'code');
    }
}
