<?php

namespace App\Models;

use App\Mail\VerifikasiEmail;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Laravel\Passport\HasApiTokens;
use Modules\Users\App\Models\Card;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $table = 'users';

    public $timestamps = true;
    protected $softDelete = true;
    protected $guarded = [
        'id',

    ];

    protected $hidden = [
        'password',
        'remember_token',
        'activated',
        'token',
        'verification_code',
        'pin',
        'fcm',
        'updated_at',
        'deleted_at',
        'email_verified_at',
    ];

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'activated',
        'token',
        'signup_ip_address',
        'signup_confirmation_ip_address',
        'signup_sm_ip_address',
        'admin_ip_address',
        'updated_ip_address',
        'deleted_ip_address',

        'plan_id',
        'google_id',
        'code',
        'ref_code',
        'saldo',
        'poin',
        'koin',
        'markup',
        'phone',
        'pin',
        'verification_code',
        'status',
        'is_kyc',
        'is_outlet',
        'fcm',
        'device_name',
        'unique_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                                => 'integer',
        'first_name'                        => 'string',
        'last_name'                         => 'string',
        'email'                             => 'string',
        'password'                          => 'string',
        'activated'                         => 'boolean',
        'token'                             => 'string',
        'signup_ip_address'                 => 'string',
        'signup_confirmation_ip_address'    => 'string',
        'signup_sm_ip_address'              => 'string',
        'admin_ip_address'                  => 'string',
        'updated_ip_address'                => 'string',
        'deleted_ip_address'                => 'string',
        'created_at'                        => 'datetime',
        'updated_at'                        => 'datetime',
        'deleted_at'                        => 'datetime',
        'poin'                              => 'integer',
        'koin'                              => 'integer',
    ];

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M Y H:i');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the socials for the user.
     */
    public function social()
    {
        return $this->hasMany(\App\Models\Social::class);
    }

    /**
     * Get the profile associated with the user.
     */
    public function profile()
    {
        return $this->hasOne(\App\Models\Profile::class);
    }

    /**
     * The profiles that belong to the user.
     */
    public function profiles()
    {
        return $this->belongsToMany(\App\Models\Profile::class)->withTimestamps();
    }

    /**
     * Check if a user has a profile.
     *
     * @param  string  $name
     * @return bool
     */
    public function hasProfile($name)
    {
        foreach ($this->profiles as $profile) {
            if ($profile->name === $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add/Attach a profile to a user.
     *
     * @param  Profile  $profile
     */
    public function assignProfile(Profile $profile)
    {
        return $this->profiles()->attach($profile);
    }

    /**
     * Remove/Detach a profile to a user.
     *
     * @param  Profile  $profile
     */
    public function removeProfile(Profile $profile)
    {
        return $this->profiles()->detach($profile);
    }

    /**
     * Get the card that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'id', 'user_id');
    }

    public static $createUrlCallback;
    public static $toMailCallback;
    
    protected function verificationUrl()
    {
        $strSign = $this->attributes['id'].$this->attributes['email'];
        return URL::temporarySignedRoute(
            'verification.email',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $this->attributes['id'],
                'sign' => hash_hmac('sha256', $strSign, $this->attributes['id'])
            ]
        );
    }

    public function sendEmailVerify()
	{
        // $this->notify(new VerifyEmail($this->attributes['email']));
        Mail::to($this->attributes['email'])->send(new VerifikasiEmail($this->attributes, $this->verificationUrl()));
	}

    public function getEmailForVerification()
	{
        return $this->attributes['email'];
	}

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Membership::class, 'id', 'plan_id');
    }
}
