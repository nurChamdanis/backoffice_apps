<?php

namespace Modules\Api\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\TransferSaldoMail;
use App\Models\Admin;
use App\Models\User;
use App\Notifications\TrxNotif;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Modules\InstTransfer\App\Models\Disbursement;
use Modules\Setting\App\Models\Setting;
use Modules\Users\App\Models\Card;
use Modules\Users\App\Models\Deposit;
use Modules\Users\App\Models\Notifikasi;

class TrfSaldoController extends Controller
{
    public function beneficiary(Request $request)
    {
        $this->validate($request, [
            'nominal' => 'required|numeric'
        ]);

        DB::beginTransaction();
        try {

            $code = 'BILPAY';
            $nominal = intval($request->nominal);
            $phone = $request->phone;
            $tujuan = str_replace('-', '', str_replace(' ', '', $request->card_number));
            $ref_id= md5(random_bytes(32));
    
            $val = Setting::where('key', 'Transfer Bilpay')->first();
            if(!isset($val)){
    
                $fee = 0;
                $fixNominal = $nominal + intval($fee);
    
            }else {
    
                $adm = json_decode($val->value);
                $fee = $adm->biaya;
                $fixNominal = $nominal + intval($fee);
            }

            if($fixNominal < 0){
                return errorResponApi('Nominal tidak sesuai dengan ketentuan transfer '.config('app.name'), 422);
            }
    
            $cek = Card::where('card_number', $tujuan)->first();
            if(isset($cek)){
                $user = User::where(['id' => userId()])->first();
                if($user->saldo > $fixNominal){

                    if(hash_equals(strval($cek->user_id), strval(userId()))){
                        return errorResponApi('Member ID tidak boleh sama dengan akun Anda', 422);
                    }
        
                    $benef = User::where('phone', $phone)->first();
                    if(isset($benef)){

                        $disb = new Disbursement();
                        $disb->user_id                  = userId();
                        $disb->ref_id                   = $ref_id;
                        $disb->nominal                  = $fixNominal;
                        $disb->bank_code                = $code;
                        $disb->account_number           = $tujuan;
                        $disb->account_holder_name      = $benef->first_name;
                        $disb->disbursement_description = 'Transfer Saldo Bilpay';
                        $disb->status                   = 'INQUIRY';
                        $disb->save();
            
                        DB::commit();
                        $data = array(
                            'user_id'                   => $disb->user_id,
                            'ref_id'                    => $disb->ref_id,
                            'nominal'                   => $disb->nominal,
                            'fee_admin'                 => $fee,
                            'bank_code'                 => $disb->bank_code,
                            'account_number'            => $disb->account_number,
                            'account_holder_name'       => $disb->account_holder_name,
                            'disbursement_description'  => $disb->disbursement_description,
                            'status'                    => $disb->status,
                        );
                        
                        return successResponse('Berhasil', $data);
                    }else {
                        return errorResponApi('Nomor telepon pengguna tidak ditemukan', 422);
                    }
                }else {
                    return errorResponApi('Saldo kamu tidak cukup', 422);
                }
            }else {
                return errorResponApi('Inquiry Gagal, Member ID tidak ditemukan', 422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return errorResponApi($th->getMessage(), 422);
        }
    }

    public function disburse(Request $request)
    {
        $val = Setting::where('key', 'maintnance_mode')->first();
        $mode = json_decode($val->value);

        if ($mode->mode == 'on') {
            $msg = 'Sedang Dalam Pemeliharaan';
            return errorResponApi($msg, 422);

        } else {

            DB::beginTransaction();
            
            $user = User::find(userId());
            $trxId      = $request->ref_id;

            $disb       = Disbursement::where(['user_id' => $user->id, 'ref_id' => $trxId])->first();
            $nominal    = intval($disb->nominal);
            $note       = $request->catatan;
            
            $benef = Card::where('card_number', $disb->account_number)->first();
            $userBenef = User::where('id', $benef->user_id)->first();

            $saldo = $user->saldo;
            if($nominal >= limitTransaksi()){
                return errorResponApi('Nominal transfer telah mencapai batas transaksi', 422);
            }

            if($saldo > $nominal){
    
                if($user->status == 'ACTIVE'){

                    if($user->is_kyc == 1){

                        $pin = Hash::check($request->pin, $user->pin);
                        if($pin == true){

                            $st = Setting::where('key', 'Transfer Bilpay')->first();
                            if(isset($st->value)){
                                $b = json_decode($st->value);
                                $by = $b->biaya;
                            }else {
                                $by = 0;
                            }

                            $pot = $nominal + intval($by);
                            $user->saldo -= intval($pot);
                            $user->save();
        
                            $userBenef->saldo += $nominal;
                            $userBenef->save();

                            $disb->disbursement_description = isset($note) ? $note : 'Transfer saldo Bilpay ke '.$userBenef->first_name;
                            $disb->status = 'SUCCESS';
                            $disb->save();

                            $tp = new Deposit();
                            $tp->user_id        = $userBenef->id;
                            $tp->payment_id     = 0;
                            $tp->order_id       = rand(1111111111, 9999999999);
                            $tp->ref_id         = $disb->ref_id;
                            $tp->nominal        = $nominal;
                            $tp->fee            = $by;
                            $tp->total_payment  = intval($nominal) + intval($by);
                            $tp->va_number      = $benef->card_number;
                            $tp->expired        = Carbon::now()->timestamp;
                            $tp->status         = 'SUCCESS';
                            $tp->save();

                            $content = 'Transfer saldo Bilpay ke nomor ' . $disb->account_number . ' sebesar ' . number_format($nominal, 2, ',', '.') . ' berhasil di proses';
                            $title = 'Transfer Bilpay';
                            Notifikasi::create([
                                'user_id'   => $user->id,
                                'title'     => $title,
                                'content'   => $content,
                                'type'      => 'Disbursement',
                                'ref_id'    => $disb->ref_id
                            ]);

                            $admin = Admin::where('id', 1)->first();
                            if(isset($admin->fcm)){
                                $fcmTokens = $admin->fcm;
                                Notification::send($admin, new TrxNotif($title, $content, null, $fcmTokens, 'ADM-TRF-SALDO'));
                            }
                
                            if(isset($user->fcm)){
                                $fcm = $user->fcm;
                                Notification::send($user, new TrxNotif($title, $content, null, $fcm, 'TRF-SALDO'));
                            }

                            $msg = 'Transfer saldo Bilpay dari ' . $user->first_name . ' sebesar ' . number_format($nominal, 2, ',', '.') . ' telah ditambahkan ke wallet Anda';
                            if(isset($userBenef->fcm)){
                                $fcm = $userBenef->fcm;
                                Notification::send($userBenef, new TrxNotif($title, $msg, null, $fcm, 'BENEFICIARY-TRF-SALDO'));
                            }

                            Notifikasi::create([
                                'user_id'   => $userBenef->id,
                                'title'     => $title,
                                'content'   => $msg,
                                'type'      => 'Disbursement',
                                'ref_id'    => $disb->ref_id
                            ]);

                            DB::commit();
                            Mail::to($user->email)->send(new TransferSaldoMail($user, $disb));
                            $data = array(
                                'user_id'                   => $disb->user_id,
                                'ref_id'                    => $disb->ref_id,
                                'nominal'                   => $disb->nominal,
                                'fee_admin'                 => $by,
                                'bank_code'                 => $disb->bank_code,
                                'account_number'            => $disb->account_number,
                                'account_holder_name'       => $disb->account_holder_name,
                                'disbursement_description'  => $disb->disbursement_description,
                                'status'                    => $disb->status,
                            );

                            return successResponse('Berhasil', $data);
    
                        }else {
    
                            return errorResponApi('PINI Anda Salah!!!', 422);
                        }
                    }else {

                        return errorResponApi('Maaf, Anda belum melakukan Verifikasi Identitas', 422);
                    }
                }else {
                    return errorResponApi('Maaf, Akun Anda tidak Aktif', 422);
                }
    
            }else {
    
                return errorResponApi('Saldo tidak mencukupi', 422);
            }
        }
    }
}
