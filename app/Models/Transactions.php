<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transactions extends Model
{
 use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'transactions';
        protected $fillable = [
        'user_id',
        'produk_id'
    ];
    
}