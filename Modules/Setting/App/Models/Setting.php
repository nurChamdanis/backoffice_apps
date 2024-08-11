<?php

namespace Modules\Setting\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Setting\Database\factories\SettingFactory;

class Setting extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'settings';
    protected $guarded = ['id'];
}
