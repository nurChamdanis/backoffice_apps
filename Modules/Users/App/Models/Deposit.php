<?php

namespace Modules\Users\App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Users\Database\factories\DepositFactory;
use App\Models\User;

class Deposit extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'deposits';
    protected $guarded = ['id'];

    public function metod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_id', 'id');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M Y H:i');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d M Y H:i');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_id', 'id');
    }
}
