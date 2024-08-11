<?php

namespace Modules\InstTransfer\App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\InstTransfer\Database\factories\DisbursementFactory;

class Disbursement extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'disbursement';
    protected $fillable = [
        'user_id',
        'ref_id',
        'nominal',
        'bank_code',
        'account_number',
        'account_holder_name',
        'disbursement_description',
        'status',
        'respon_json',
        'callback_json',
    ];

    protected $dates = ['deleted_at'];

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M Y H:i');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
