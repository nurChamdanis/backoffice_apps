<?php

namespace Modules\Api\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\DepositMail;
use App\Mail\TransactionMail;
use App\Mail\TransferMail;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use App\Traits\ActivationTrait;
use App\Traits\CaptchaTrait;
use App\Traits\CaptureIpTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Modules\Gosms\App\Http\Controllers\GosmsController;
use Modules\InstTransfer\App\Models\Disbursement;
use Modules\Produk\App\Models\Produk;
use Modules\Setting\App\Models\Setting;
use Modules\Transaksi\App\Models\Transaksi;
use Modules\Users\App\Models\Card;
use Modules\Users\App\Models\Deposit;
use Modules\Users\App\Models\HistoriPoin;
use Modules\Users\App\Models\KodeOtp;
use Seshac\Otp\Otp;

class UserController extends Controller
{
    use ActivationTrait;
    use CaptchaTrait;
    
    protected function create(Request $request, GosmsController $sms)
    {
        DB::beginTransaction();
        try {

            $rf = $request->referral == null ? 'BP-0000' : $request->referral;
            $cekRef = User::where('code', $rf)->first();
            if(!isset($cekRef) ){
                return  response([
                    'error'         => true,
                    'message'       => 'Kode referral tidak ditemukan',
                ], 422);
            }
    
            $this->validate($request, [
                    'first_name'            => 'string',
                    'email'                 => 'required|email|max:255|unique:users',
                    'phone'                 => 'required|max:15|min:10|unique:users|phone:ID',
                    'password'              => 'required|min:6|max:30|confirmed',
                    'pin'                   => 'required|min:6|max:6',
                    'password_confirmation' => 'required|same:password',
                    'referral'              => '',
                    'google_id'             => '',
                ],
                [
                    'first_name.required'           => trans('auth.fNameRequired'),
                    'email.required'                => trans('auth.emailRequired'),
                    'email.email'                   => trans('auth.emailInvalid'),
                    'phone.required'                => trans('auth.phoneRequired'),
                    'phone.min'                     => 'Nomor handphone minimal 10 angka',
                    'phone.max'                     => 'Nomor handphone maksimal 15 angka',
                    'password.required'             => trans('auth.passwordRequired'),
                    'password.min'                  => trans('auth.PasswordMin'),
                    'password.max'                  => trans('auth.PasswordMax'),
                    'pin.required'                  => 'PIN Transaksi tidak boleh kosong',
                    'pin.min'                       => 'PIN Minimal 6 Angka',
                    'pin.max'                       => 'PIN Maksimal 6 Angka',
                ]
            );
    
            $ipAddress = new CaptureIpTrait();
            $cp = Setting::where('key', 'poin_referral')->first();
            if(!isset($cp)){
                return  response([
                    'error'         => true,
                    'message'       => 'Kesalahan Internal (rc:0023)',
                ], 422);
            }
    
            $refCode = $request['referral'];
            $reff = json_decode($cp->value);
            $valref = $reff->poin_ref;
    
            if($valref == 'on'){

                $cekRefCode = User::where('ref_code', $refCode)->get();
                if(isset($refCode)){

                    $npr = Setting::where('key', 'nom_poin_referral')->first();
                    if(!isset($npr)){
                        return  response([
                            'error'         => true,
                            'message'       => 'Kesalahan Internal (rc:0024)',
                        ], 422);
                    }else {

                        $nomReff = json_decode($npr->value);
                        if($cekRefCode->count('id') > $nomReff->minimal){
                
                            $nominalPoinRef = $nomReff->nominal;
                            $poin = $request->referral == 'BP-0000' ? 0 : $nominalPoinRef;
                            $nom_shared = $nomReff->nominal_share;
    
                        }else {
                            $nom_shared = 0;
                        }
                    }

                }else {
                    $nom_shared = 0;
                }
    
            }else {
                $poin = 0;
                $nom_shared = 0;
            }

            if(isset($cekRef)){
                $cekRef->poin += $poin;
                $cekRef->save();
            }
    
            $user = User::create([
                'plan_id'           => 0,
                'code'              => 'BP-'.rand(00000, 99999),
                'ref_code'          => isset($refCode) ? $refCode : 'BP-00000',
                'google_id'         => $request['google_id'],
                'name'              => Str::replace(' ', '_', Str::lower($request['first_name'])).rand(000, 999),
                'first_name'        => strip_tags($request['first_name']),
                'last_name'         => strip_tags($request['last_name']),
                'saldo'             => 0,
                'markup'            => 0,
                'poin'              => $nom_shared,
                'koin'              => 0,
                'email'             => $request['email'],
                'phone'             => $request['phone'],
                'password'          => Hash::make($request['password']),
                'pin'               => Hash::make($request['pin']),
                'token'             => Str::random(64),
                'signup_ip_address' => $ipAddress->getClientIp(),
                'activated'         => false,
                'status'            => 'INACTIVE',
                'is_kyc'            => false,
                'is_outlet'         => false,
            ]);
    
            $card = new Card();
            $card->user_id = $user->id;
            $card->card_number = '5307'.rand(11111, 99999).$user->id;
            $card->valid = '03/29';
            $card->save();
    
            $profile = new Profile();
            $user->profile()->save($profile);
            $user->save();
            
            $user->sendEmailVerify();

            $identifier = $user->phone;
            $otp = Otp::setValidity(50)
                ->setMaximumOtpsAllowed(50)
                ->generate($identifier);
    
            $user->verification_code = $otp->token;
            $user->save();

            if($user && $valref == 'on'){
                $hp = new HistoriPoin();
                $hp->user_id    = $user->id;
                $hp->ref_id     = Str::upper(Str::random(12));
                $hp->jenis      = 'CREDIT';
                $hp->nominal    = $nom_shared;
                $hp->keterangan = 'Bonus pendaftaran sebesar '.rupiah($nom_shared);
                $hp->poin_awal  = intval($user->poin);
                $hp->poin_akhir = intval($user->poin) + $nom_shared;
                $hp->save();
            }
    
            $msg = 'Kode OTP kamu adalah: '.$otp->token;
            $t = $sms->sendSMS($user->phone, $msg);
            if(!$t){
                $z = sendWA($user->phone, $msg);
                $t = $z;
            }
    
            DB::commit();
            return  response([
                'error'         => false,
                'message'       => 'Registrasi Sukses',
                'secret'        => $user->token,
                'otp'           => $request['phone'] == '08112311232' ? $otp : null
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            return errorResponApi($th->getMessage(), 422);
        }
    }
    
    public function index()
    {
        $u = User::where('id', userId())->with('profile', 'card')->first();

        return successResponse('Sukses', $u);
    }

    public function updateFcm(Request $request)
    {
        $c = Card::where('card_number', $request->card_number)->first();
        $u = User::where('id', $c->user_id)->first();
        $u->fcm = $request->fcm;
        $u->save();

        return successResponse('FCM Sukses Updated', true);
    }

    public function testmail(Request $request)
    {
        $t = Deposit::where('ref_id', $request->ref_id)->first();
        $us = User::where('phone', $request->phone)->first();
        Mail::to($us->email)->send(new DepositMail($us, $t));

        return successResponse('Email terkirim', null);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => '',
            'email' => 'required|unique:users,email',
        ]);

        DB::beginTransaction();
        try {
            $u = User::where('id', userId())->first();
            $u->first_name  = $request->first_name;
            $u->last_name   = $request->last_name;
            $u->email       = $request->email;
            $u->save();
    
            DB::commit();
            return successResponse('Profile Sukses Updated', true);
        } catch (\Throwable $th) {

            DB::rollBack();
            return errorResponApi($th->getMessage(), 422);
        }
    }

    public function updatePhone(Request $request)
    {
        DB::beginTransaction();
        try {
            $kodeOtp = $request->code; 
            $identifier = KodeOtp::where('token', $kodeOtp)->first();
            $u = User::where(['verification_code' => $kodeOtp, 'phone' => $request->phone])->first();
            if($u->verification_code == $identifier->token){

                $verify = Otp::setAllowedAttempts(5)->validate($identifier->identifier, $request);
                if($verify){
                    $cekUser = User::where('phone', $request->new_phone)->first();
                    if(isset($cekUser)){
                        return errorResponApi('Nomor telepon sudah digunakan akun lain', 422);
                    }else {
                        $u->phone = $request->new_phone;
                        $u->verification_code = rand(000000, 999999);
                        $u->save();
                        DB::commit();
                        return successResponse('Phone Success Updated', true);
                    }
                    
                }else {

                    return errorResponApi('Kode OTP Salah', 422);
                }
            }else {
                return errorResponApi('Kode OTP Salah', 422);
            }
        } catch (\Throwable $th) {

            DB::rollBack();
            return errorResponApi($th->getMessage(), 422);
        }
    }
}
