<?php

namespace Modules\Transaksi\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Transaksi\Database\factories\KodeUnikFactory;

class KodeUnik extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'unique_codes';
    protected $guarded = ['id'];
}
