<?php 
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membership extends Model {
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'memberships';
    protected $guarded = ['id'];
    protected $fillable = [
        'name_membership',
        'limit_transaction'
    ];
    
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M Y H:i');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d M Y H:i');
    }
}
