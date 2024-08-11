<?php

namespace Modules\Setting\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Setting\Database\factories\ApiKeyFactory;

class ApiKey extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'api_keys';
    protected $guarded = ['id'];
}
