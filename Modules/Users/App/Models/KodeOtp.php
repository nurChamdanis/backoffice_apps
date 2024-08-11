<?php

namespace Modules\Users\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Users\Database\factories\KodeOtpFactory;

class KodeOtp extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'otps';
}
