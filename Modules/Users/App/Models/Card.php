<?php

namespace Modules\Users\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Users\Database\factories\CardFactory;

class Card extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'cards';
    protected $guarded = ['id'];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];
}
