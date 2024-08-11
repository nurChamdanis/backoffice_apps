<?php

namespace Modules\Api\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\App\Models\Margin;
use Modules\InstTransfer\App\Models\Disbursement;
use Modules\Klick\App\Http\Controllers\KlickController;
use Modules\Setting\App\Models\Setting;
use Modules\Users\App\Models\Notifikasi;

class TrfBankController extends Controller
{
    public function listBankTransfer(KlickController $klik)
    {
        $b = $klik->listBank();
        return $b;
    }

    public function beneficiary(Request $request, KlickController $klik)
    {
        $code = $request->swift_code;
        $nominal = intval($request->nominal);
        $tujuan = str_replace('-', '', str_replace(' ', '', $request->tujuan));

        $fixNominal = $nominal + intval(biayaTransfer());

        $cek = $klik->cekRekening($request, $code);
        if(isset($cek[0]->data)){

            $disb = new Disbursement();
            $disb->user_id = userId();
            $disb->ref_id = $cek[0]->data->trx_id;
            $disb->nominal = $fixNominal;
            $disb->bank_code = $code;
            $disb->account_number = $tujuan;
            $disb->account_holder_name = $cek[0]->data->account_holder;
            $disb->disbursement_description = $request->catatan == null ? 'Instan Transfer' : $request->catatan;
            $disb->status = 'INQUIRY';
            $disb->save();

            sleep(5);
            $dt = Disbursement::select(
                'user_id',
                'ref_id',
                'nominal',
                'bank_code',
                'account_number',
                'account_holder_name',
                'disbursement_description',
                'status',
            )->where('ref_id', $cek[0]->data->trx_id)->first();

            $data = array(
                'user_id'                   => $dt->user_id,
                'ref_id'                    => $dt->ref_id,
                'nominal'                   => $nominal,
                'fee_admin'                 => biayaTransfer(),
                'amount'                    => $dt->nominal,
                'bank_code'                 => $dt->bank_code,
                'account_number'            => $dt->account_number,
                'account_holder_name'       => $dt->account_holder_name,
                'disbursement_description'  => $dt->disbursement_description,
                'status'                    => $dt->status,
            );

            return successResponse('Berhasil', $data);
            
        }else {
            return $cek;
        }
    }

    public function statusBeneficiary(Request $request)
    {
        $trxId = $request->trx_id;
        $d = Disbursement::where('ref_id', $trxId)->where('user_id', userId())->first();

        $data = array(
            'ref_id'                    => $d->ref_id,
            'nominal'                   => intval($d->nominal),
            'bank_code'                 => $d->bank_code,
            'account_number'            => $d->account_number,
            'account_holder_name'       => $d->account_holder_name,
            'disbursement_description'  => $d->disbursement_description,
            'status'                    => $d->status,
        );

        return successResponse('Berhasil', $data);

    }

    public function disburse(Request $request, KlickController $klik)
    {
        $val = Setting::where('key', 'maintnance_mode')->first();
        $mode = json_decode($val->value);

        DB::beginTransaction();
        try {
            if ($mode->mode == 'on') {
                $msg = 'Sedang Dalam Pemeliharaan';
                return errorResponApi($msg, 422);
    
            } else {
    
                $user = User::find(userId());
                $trxId      = $request->trx_id;
    
                $disb       = Disbursement::where(['user_id' => $user->id, 'ref_id' => $trxId])->first();
                $nominal    = intval($disb->nominal);
                $note       = $request->catatan;
    
                if($nominal >= limitTransaksi()){
                    return errorResponApi('Nominal transfer telah mencapai batas transaksi', 422);
                }
        
                $saldo = $user->saldo;
                if($saldo > $nominal){
        
                    $val = Setting::where('key', 'maintnance_mode')->first();
                    $mode = json_decode($val->value);
        
                    if ($mode->mode == 'on') {
                        return errorResponApi('Sedang dalam pemeliharaan server', 422);
        
                    }else {
        
                        if($user->status == 'ACTIVE'){
        
                            $pin = Hash::check($request->pin, $user->pin);
                            if($pin == true){

                                if($disb->account_holder_name == 'N/A'){
                                    return errorResponApi('Transfer bank tidak dapat diteruskan, nama penerima tidak diketahui', 422);
                                }else {
                                    
                                    $pot = $nominal;
                                    $user->saldo -= intval($pot);
                                    $user->save();
                
                                    $cost = intval($nominal) - intval(biayaTransfer());
                                    $b = $klik->transferBank($trxId, $cost, $note);
                                    // return $b;
    
                                    $disb->disbursement_description = $note;
                                    $disb->status = 'SUCCESS';
                                    $disb->save();
    
                                    $valMrg =  intval(biayaTransfer()) - $b[0]->data->fee;
                                    $mr = new Margin();
                                    $mr->ref_id     = $disb->ref_id;
                                    $mr->produk_id  = $disb->bank_code;
                                    $mr->value      = $valMrg;
                                    $mr->type       = 'INSTAN_TRANSFER';
                                    $mr->posted     = false;
                                    $mr->save();
    
                                    $content = 'Transfer Bank ke nomor rek ' . $disb->account_number . ' sebesar ' . number_format($nominal, 2, ',', '.') . ' berhasil di proses';
                                    Notifikasi::create([
                                        'user_id'   => $user->id,
                                        'title'     => 'Transfer Bank',
                                        'content'   => $content,
                                        'type'      => 'Transfer',
                                        'ref_id'    => $disb->ref_id
                                    ]);
    
                                    DB::commit();
    
                                    $resp = array(
                                        "trx_id"    => $b[0]->data->trx_id,
                                        "ref_id"    => $b[0]->data->ref_id,
                                        "status"    => $b[0]->data->status,
                                        "amount"    => $b[0]->data->amount,
                                        "fee"       => biayaTransfer(),
                                        "total"     => intval($b[0]->data->amount) + biayaTransfer(),
                                        "currency"  => "IDR"
                                    );
                                    return successResponse('Transfer Berhasil', $resp);
                                }

        
                            }else {
        
                                return errorResponApi('PINI Anda Salah!!!', 422);
                            }
                            
                        }else {
                            return errorResponApi('Maaf, Akun Anda tidak Aktif', 422);
                        }
        
                    }
        
                }else {
        
                    return errorResponApi('Saldo tidak mencukupi', 422);
                }
            }
        } catch (BadResponseException $ex) {
            
            DB::rollBack();
            $response = $ex->getResponse();
            $jsonBody = (string) $response->getBody();
            return json_decode($jsonBody);
        }
    }
}
