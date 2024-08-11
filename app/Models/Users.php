<?php 
namespace App\Models;

use App\Mail\VerifikasiEmail;
use App\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\HasApiTokens;

class Users extends Authenticatable
{
	use Notifiable, HasApiTokens;
	use SoftDeletes;
	

	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'users';
	

	/**
     * The table primary key field
     *
     * @var string
     */
	protected $primaryKey = 'id';
	protected $fillable = ['email','password','phone','picture','username','account_status','plan_id','code','ref_code','google_id','verification_code','fcm','pin', 'saldo', 'poin', 'koin', 'markup','status','is_kyc','is_outlet','first_name','last_name','signup_ip_address','signup_confirmation_ip_address','signup_sm_ip_address','admin_ip_address','updated_ip_address','deleted_ip_address','saldo_balance','role_name','role_id'];
	public $timestamps = true;
	const CREATED_AT = 'created_at'; 
	const UPDATED_AT = 'updated_at'; 
	const DELETED_AT = 'deleted_at'; 
	

	/**
     * Set search query for the model
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param string $text
     */
	public static function search($query, $text){
		//search table record 
		$search_condition = '(
				email LIKE ?  OR 
				phone LIKE ?  OR 
				username LIKE ?  OR 
				account_status LIKE ?  OR 
				role_name LIKE ?  OR 
				role_id LIKE ?  OR 
				id LIKE ?  OR 
				first_name LIKE ?  OR 
				last_name LIKE ?  OR 
				signup_ip_address LIKE ?  OR 
				signup_confirmation_ip_address LIKE ?  OR 
				signup_sm_ip_address LIKE ?  OR 
				admin_ip_address LIKE ?  OR 
				updated_ip_address LIKE ?  OR 
				deleted_ip_address LIKE ?  OR 
				code LIKE ?  OR 
				ref_code LIKE ?  OR 
				google_id LIKE ?  OR 
				verification_code LIKE ?  OR 
				fcm LIKE ?  OR 
				pin LIKE ?  OR 
				markup LIKE ?  OR 
				status LIKE ?  OR 
				is_kyc LIKE ?  OR 
				is_outlet LIKE ? 
		)';
		$search_params = [
			"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
		];
		//setting search conditions
		$query->whereRaw($search_condition, $search_params);
	}
	

	/**
     * return list page fields of the model.
     * 
     * @return array
     */
	public static function listFields(){
		return [ 
			"picture",
			"email",
			"created_at",
			"updated_at",
			"phone",
			"username",
			"saldo_balance",
			"account_status",
			"role_name",
			"role_id",
			"id" 
		];
	}
	

	/**
     * return exportList page fields of the model.
     * 
     * @return array
     */
	public static function exportListFields(){
		return [ 
			"picture",
			"email",
			"created_at",
			"updated_at",
			"phone",
			"username",
			"saldo_balance",
			"account_status",
			"role_name",
			"role_id",
			"id" 
		];
	}
	

	/**
     * return view page fields of the model.
     * 
     * @return array
     */
	public static function viewFields(){
		return [ 
			"id",
			"first_name",
			"last_name",
			"email",
			"email_verified_at",
			"signup_ip_address",
			"signup_confirmation_ip_address",
			"signup_sm_ip_address",
			"admin_ip_address",
			"updated_ip_address",
			"deleted_ip_address",
			"created_at",
			"updated_at",
			"phone",
			"username",
			"saldo_balance",
			"account_status",
			"plan_id",
			"code",
			"ref_code",
			"google_id",
			"verification_code",
			"fcm",
			"pin",
			"markup",
			"status",
			"is_kyc",
			"is_outlet",
			"role_name",
			"role_id" 
		];
	}
	

	/**
     * return exportView page fields of the model.
     * 
     * @return array
     */
	public static function exportViewFields(){
		return [ 
			"id",
			"code",
			"ref_code",
			"name",
			"first_name",
			"last_name",
			"email",
			"phone",
			"saldo",
			"poin",
			"koin",
			"markup",
			"is_kyc",
			"status",
			"created_at",
			"updated_at",
		];
	}
	

	/**
     * return accountedit page fields of the model.
     * 
     * @return array
     */
	public static function accounteditFields(){
		return [ 
			"first_name",
			"last_name",
			"signup_ip_address",
			"signup_confirmation_ip_address",
			"signup_sm_ip_address",
			"admin_ip_address",
			"updated_ip_address",
			"deleted_ip_address",
			"phone",
			"picture",
			"username",
			"saldo_balance",
			"plan_id",
			"code",
			"ref_code",
			"google_id",
			"verification_code",
			"fcm",
			"pin",
			"markup",
			"status",
			"is_kyc",
			"is_outlet",
			"id",
			"role_name",
			"role_id" 
		];
	}
	

	/**
     * return accountview page fields of the model.
     * 
     * @return array
     */
	public static function accountviewFields(){
		return [ 
			"id",
			"first_name",
			"last_name",
			"email",
			"email_verified_at",
			"signup_ip_address",
			"signup_confirmation_ip_address",
			"signup_sm_ip_address",
			"admin_ip_address",
			"updated_ip_address",
			"deleted_ip_address",
			"created_at",
			"updated_at",
			"phone",
			"username",
			"saldo_balance",
			"account_status",
			"plan_id",
			"code",
			"ref_code",
			"google_id",
			"verification_code",
			"fcm",
			"pin",
			"markup",
			"status",
			"is_kyc",
			"is_outlet",
			"role_name",
			"role_id" 
		];
	}
	

	/**
     * return exportAccountview page fields of the model.
     * 
     * @return array
     */
	public static function exportAccountviewFields(){
		return [ 
			"id",
			"first_name",
			"last_name",
			"email",
			"email_verified_at",
			"signup_ip_address",
			"signup_confirmation_ip_address",
			"signup_sm_ip_address",
			"admin_ip_address",
			"updated_ip_address",
			"deleted_ip_address",
			"created_at",
			"updated_at",
			"phone",
			"username",
			"saldo_balance",
			"account_status",
			"plan_id",
			"code",
			"ref_code",
			"google_id",
			"verification_code",
			"fcm",
			"pin",
			"markup",
			"status",
			"is_kyc",
			"is_outlet",
			"role_name",
			"role_id" 
		];
	}
	

	/**
     * return edit page fields of the model.
     * 
     * @return array
     */
	public static function editFields(){
		return [ 
			"first_name",
			"last_name",
			"signup_ip_address",
			"signup_confirmation_ip_address",
			"signup_sm_ip_address",
			"admin_ip_address",
			"updated_ip_address",
			"deleted_ip_address",
			"phone",
			"picture",
			"username",
			"saldo_balance",
			"plan_id",
			"code",
			"ref_code",
			"google_id",
			"verification_code",
			"fcm",
			"pin",
			"markup",
			"status",
			"is_kyc",
			"is_outlet",
			"role_name",
			"role_id",
			"id" 
		];
	}
	

	/**
     * Get current user name
     * @return string
     */
	public function UserName(){
		return $this->username;
	}
	

	/**
     * Get current user id
     * @return string
     */
	public function UserId(){
		return $this->id;
	}
	public function UserEmail(){
		return $this->email;
	}
	public function UserPhoto(){
		return $this->picture;
	}
	public function UserRole(){
		return $this->role_name;
	}
	

	/**
     * Send Password reset link to user email 
	 * @param string $token
     * @return string
     */
	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ResetPassword($token));
	}

    public function getEmailForVerification()
	{
        return $this->attributes['email'];
	}

	public function sendEmailVerify()
	{
		Mail::to($this->attributes['email'])->send(new VerifikasiEmail($this->attributes));
	}
}
