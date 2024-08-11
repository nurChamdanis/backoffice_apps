<?php

namespace Modules\Klick\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\DepositMail;
use App\Mail\TransferMail;
use App\Models\Admin;
use App\Models\User;
use App\Notifications\TrxNotif;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Setting\App\Models\ApiKey;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Modules\Admin\App\Models\Margin;
use Modules\InstTransfer\App\Models\Disbursement;
use Modules\Setting\App\Models\Setting;
use Modules\Users\App\Models\Deposit;
use Modules\Users\App\Models\HistoriKoin;
use Modules\Users\App\Models\HistoriPoin;
use Modules\Users\App\Models\Notifikasi;
use GuzzleHttp\Exception\BadResponseException;

class KlickController extends Controller
{
    public function cekSaldo()
    {
        try {
            $key = ApiKey::where('provider', 'KLICK')->first();
            $requestContent = [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                    'X-Signature'   => signKlik(),
                    'X-Api-Key'     => $key->key,
                    'Authorization' => 'Bearer '.$key->token,
                ],
                'json' => [
                    'username'      => $key->merchant_id
                ]
            ];
        
            $client = new Client();
            $res = $client->post($key->api_url.'cek-balance', $requestContent);
            $result = $res->getBody()->getContents();
            $res = json_decode($result);
            return $res;

        } catch (BadResponseException $ex) {
            $response = $ex->getResponse();
            $jsonBody = (string) $response->getBody();
            return json_decode($jsonBody);
        }
    }

    public function callback(Request $request)
    {
        Log::info('CALLBACK KLICK '.$request->ref_id.' | STATUS: '.$request->code.' | TYPE: '.$request->type);
        $dis = Disbursement::where('ref_id', $request->ref_id)->first();
        if(isset($dis)){

            $user = User::find($dis->user_id);
            if($request->type == 'INQUIRY'){
                
                Log::info('CALLBACK KLIK INQUIRY '.$request->namaRekening);
                $dis->account_holder_name = $request->namaRekening;
                $dis->save();

                $title = 'Inquiry Instan Transfer';
                $message = 'Instan transfer '.$request->namaRekening;
                $admin = Admin::where('id', 1)->first();
                if(isset($admin->fcm)){
                    $fcmTokens = $admin->fcm;
                    Notification::send($admin, new TrxNotif($title, $message, null, $fcmTokens, 'BENEFICIARY'));
                }

                if(isset($user->fcm)){
                    $fcm = $user->fcm;
                    Notification::send($user, new TrxNotif($title, $message, null, $fcm, 'USER-BENEFICIARY'));
                }

                return true;
                
            }else {
                
                Log::info('CALLBACK KLIK DISBURSEMENT '.$request->details['tujuan'].' - '.$request->details['berita']);

                switch ($request->details['status']) {
                    case '0':
                        $sts = 'PROCESSING';
                        break;

                    case '1':
                        $sts = 'SUCCESS';
                        
                        $mr = Margin::where('ref_id', $dis->ref_id)->first();
                        $mr->posted = true;
                        $mr->save();

                        break;

                    case '2':
                        $us = User::where('id', $dis->user_id)->first();
                        $tk = new HistoriKoin();
                        $tk->user_id    = $us->id;
                        $tk->ref_id     = $dis->ref_id;
                        $tk->jenis      = 'CREDIT';
                        $tk->nominal    = $dis->nominal;
                        $tk->keterangan = 'Refund transaksi sebesar '.rupiah($dis->nominal);
                        $tk->koin_awal  = intval($us->koin);
                        $tk->koin_akhir = intval($us->koin) + $dis->nominal;
                        $tk->save();

                        $us->koin += $dis->nominal;
                        $us->save();

                        $sts = 'REFUNDED';
                        break;

                    case '3':
                        $us = User::where('id', $dis->user_id)->first();
                        $tk = new HistoriKoin();
                        $tk->user_id    = $us->id;
                        $tk->ref_id     = $dis->ref_id;
                        $tk->jenis      = 'CREDIT';
                        $tk->nominal    = $dis->nominal;
                        $tk->keterangan = 'Refund transaksi sebesar '.rupiah($dis->nominal);
                        $tk->koin_awal  = intval($us->koin);
                        $tk->koin_akhir = intval($us->koin) + $dis->nominal;
                        $tk->save();

                        $us->koin += $dis->nominal;
                        $us->save();
                        
                        $sts = 'FAILED';
                        break;
                    case '4':

                        $us = User::where('id', $dis->user_id)->first();

                        $tk = new HistoriKoin();
                        $tk->user_id    = $us->id;
                        $tk->ref_id     = $dis->ref_id;
                        $tk->jenis      = 'CREDIT';
                        $tk->nominal    = $dis->nominal;
                        $tk->keterangan = 'Refund transaksi sebesar '.rupiah($dis->nominal);
                        $tk->koin_awal  = intval($us->koin);
                        $tk->koin_akhir = intval($us->koin) + $dis->nominal;
                        $tk->save();

                        $us->koin += $dis->nominal;
                        $us->save();
                        
                        $sts = 'FAILED';
                        break;
                }
                $dis->account_number            = $request->details['tujuan'];
                $dis->status                    = $sts;
                $dis->save();

                $title = 'Instan Transfer';
                $message = 'Instan Transfer dengan tujuan '.$request->details['tujuan'].' '.$sts;
                $admin = Admin::where('id', 1)->first();
                if(isset($admin->fcm)){
                    $fcmTokens = $admin->fcm;
                    Notification::send($admin, new TrxNotif($title, $message, null, $fcmTokens, 'DISBURSEMENT'));
                }

                $content = 'Transfer Bank ke nomor rek ' . $dis->account_number . ' sebesar ' . number_format($dis->nominal, 0, ',', '.') . ' '.$sts;
                if(isset($user->fcm)){
                    $fcm = $user->fcm;
                    Notification::send($user, new TrxNotif($title, $content, null, $fcm, 'USER-DISBURSEMENT'));
                }

                $n = Notifikasi::where('ref_id', $dis->ref_id)->first();
                if(isset($n)){
                    $n->content   = $content;
                    $n->save();
                }

                Mail::to($user->email)->send(new TransferMail($user, $dis));
                return true;
                
            }

        }else {

            if($request->type == 'TOPUP'){

                $tp = Deposit::where('ref_id', $request->ref_id)->first();
                if($request->code == '200'){
                    $us = User::where('id', $tp->user_id)->first();

                    $cp = Setting::where('key', 'poin_deposit')->first();
                    if(!isset($cp)){
                        return  response([
                            'error'         => true,
                            'message'       => 'Kesalahan Internal (rc:0025)',
                        ], 422);
                    }

                    if($tp->status == 'PENDING'){

                        $poinDep = json_decode($cp->value);
                        $valDep = $poinDep->poin_depo;
                        if($valDep == 'on'){
                            $npr = Setting::where('key', 'nom_poin_deposit')->first();
                            if(!isset($npr)){
                                return  response([
                                    'error'         => true,
                                    'message'       => 'Kesalahan Internal (rc:0026)',
                                ], 422);
                            }
    
                            $nomPoin = json_decode($npr->value);
                            $nominalPoinDeposit = $nomPoin->nominal;
                            $minDep = $nomPoin->minimal;
                            $poin = $nominalPoinDeposit;

                            if($tp->nominal > $minDep){

                                $tk = new HistoriPoin();
                                $tk->user_id    = $us->id;
                                $tk->ref_id     = $tp->ref_id;
                                $tk->jenis      = 'CREDIT';
                                $tk->nominal    = $poin;
                                $tk->keterangan = 'Bonus poin sebesar '.rupiah($poin);
                                $tk->poin_awal  = intval($us->poin);
                                $tk->poin_akhir = intval($us->poin) + $poin;
                                $tk->save();

                                $us->poin += $poin;
                            }
    
                        }else {
                            $minDep = 0;
                            $poin = 0;

                            if($tp->nominal > $minDep){
                                $us->poin += $poin;
                            }
                        }

                        $us->saldo += $tp->nominal;
                        $us->save();
                    }
                    
                    $tp->status = 'SUCCESS';
                    $tp->save();

                    $title = 'Deposit Saldo';
                    $message = 'Top up saldo Bilpay oleh '.$us->name.' berhasil';
                    $admin = Admin::where('id', 1)->first();
                    if(isset($admin->fcm)){
                        $fcmTokens = $admin->fcm;
                        Notification::send($admin, new TrxNotif($title, $message, null, $fcmTokens, 'DESPOIT'));
                    }

                    if(isset($us->fcm)){
                        $fcm = $us->fcm;
                        $msg = 'Top up saldo Bilpay sebesar '.rupiah($tp->nominal).' telah ditambahkan ke wallet Anda';
                        Notification::send($us, new TrxNotif($title, $msg, null, $fcm, 'USER-DEPOSIT'));
                    }

                    Mail::to($us->email)->send(new DepositMail($us, $tp));
                    
                    
                    Log::info('TOPUP '.$request->ref_id.' UNTUK '.$us->name.' BERHASIL MASUK');
                    return true;
                }
            }
        }
    }

    public function createVa($nominal, $code)
    {
        $key = ApiKey::where('provider', 'KLICK')->first();
        $requestContent = [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'nominal'   => $nominal,
                'kodeBank'  => $code,
            ]
        ];
    
        $client = new Client();
        $res = $client->post($key->api_url.'mitra/tiket-deposit?X-Access-Key='.$key->key.'&X-MerchantId='.$key->merchant_id.'&X-Signature='.signKlik(), $requestContent);
        $result = $res->getBody()->getContents();
        $res = json_decode($result);
        return $res;
    }

    public function cekRekening(Request $request, $code)
    {
        try {
            $key = ApiKey::where('provider', 'KLICK')->first();
            $requestContent = [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                    'X-Signature'   => signKlik(),
                    'X-Api-Key'     => $key->key,
                    'Authorization' => 'Bearer '.$key->token,
                ],
                'json' => [
                    'nominal'   => $request->nominal,
                    'tujuan'    => $request->tujuan,
                    'kodeBank'  => $code,
                    'phone'     => $key->phone,
                    'username'  => $key->merchant_id
                ]
            ];
        
            $client = new Client();
            $res = $client->post($key->api_url.'inquiry-transfer', $requestContent);
            $result = $res->getBody()->getContents();
            $res = json_decode($result);
            return $res;

        } catch (BadResponseException $ex) {
            $response = $ex->getResponse();
            $jsonBody = (string) $response->getBody();
            return json_decode($jsonBody);
        }
    }

    public function transferBank($trxId, $nominal, $note)
    {
        try {
            $key = ApiKey::where('provider', 'KLICK')->first();
            $requestContent = [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                    'X-Signature'   => signKlik(),
                    'X-Api-Key'     => $key->key,
                    'Authorization' => 'Bearer '.$key->token,
                ],
                'json' => [
                    'trx_id'    => $trxId,
                    'nominal'   => intval($nominal),
                    'berita'    => $note,
                    'username'  => $key->merchant_id,
                ]
            ];
        
            $client = new Client();
            $res = $client->post($key->api_url.'create-transfer', $requestContent);
            $result = $res->getBody()->getContents();
            $res = json_decode($result);
            return $res;

        } catch (BadResponseException $ex) {
            $response = $ex->getResponse();
            $jsonBody = (string) $response->getBody();
            return json_decode($jsonBody);
        }
    }

    public function listBank()
    {
        try {
            $key = ApiKey::where('provider', 'KLICK')->first();
            $requestContent = [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                    'X-Signature'   => signKlik(),
                    'X-Api-Key'     => $key->key,
                    'Authorization' => 'Bearer '.$key->token,
                ],
            ];
        
            $client = new Client();
            $res = $client->post($key->api_url.'list-bank-transfer', $requestContent);
            $result = $res->getBody()->getContents();
            $res = json_decode($result);
            return $res;

        } catch (BadResponseException $ex) {
            $response = $ex->getResponse();
            $jsonBody = (string) $response->getBody();
            return json_decode($jsonBody);
        }
    }

    public function cekStatus($trx_id)
    {
        try {
            $key = ApiKey::where('provider', 'KLICK')->first();
            $requestContent = [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                    'X-Signature'   => signKlik(),
                    'X-Api-Key'     => $key->key,
                    'Authorization' => 'Bearer '.$key->token,
                ],
                'json' => [
                    'trx_id'            => $trx_id,
                    'username'          => $key->merchant_id,
                ]
            ];
        
            $client = new Client();
            $res = $client->post($key->api_url.'cek-status-transfer', $requestContent);
            $result = $res->getBody()->getContents();
            $res = json_decode($result);
            return $res;

        } catch (BadResponseException $ex) {
            $response = $ex->getResponse();
            $jsonBody = (string) $response->getBody();
            return json_decode($jsonBody);
        }
    }

    public function station()
    {
        try {
            $key = ApiKey::where('provider', 'KLICK')->first();
            $requestContent = [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                    'X-Signature'   => signKlik(),
                    'X-Api-Key'     => $key->key,
                    'Authorization' => 'Bearer '.$key->token,
                ],
            ];
        
            $client = new Client();
            $res = $client->post($key->api_url.'travel/train/list-station', $requestContent);
            $result = $res->getBody()->getContents();
            $res = json_decode($result);
            return $res;

        } catch (BadResponseException $ex) {
            $response = $ex->getResponse();
            $jsonBody = (string) $response->getBody();
            return json_decode($jsonBody);
        }
    }

    public function searchTrain(Request $request)
    {
        try {
            $key = ApiKey::where('provider', 'KLICK')->first();
            $requestContent = [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                    'X-Signature'   => signKlik(),
                    'X-Api-Key'     => $key->key,
                    'Authorization' => 'Bearer '.$key->token,
                ],
                'json' => [
                    'origin'        => $request->origin,
                    'destination'   => $request->destination,
                    'date'          => $request->date
                ]
            ];
        
            $client = new Client();
            $res = $client->post($key->api_url.'travel/train/list-train', $requestContent);
            $result = $res->getBody()->getContents();
            $res = json_decode($result);
            return $res;

        } catch (BadResponseException $ex) {
            $response = $ex->getResponse();
            $jsonBody = (string) $response->getBody();
            return json_decode($jsonBody);
        }
    }

    public function bookTrain(Request $request)
    {
        try {
            $key = ApiKey::where('provider', 'KLICK')->first();
            $requestContent = [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                    'X-Signature'   => signKlik(),
                    'X-Api-Key'     => $key->key,
                    'Authorization' => 'Bearer '.$key->token,
                ],
                'json' => [
                    "origin"        => $request->origin,
                    "destination"   => $request->destination,
                    "date"          => $request->date,
                    "trainNumber"   => $request->trainNumber,
                    "grade"         => $request->grade,
                    "class"         => $request->class,
                    "adult"         => $request->adult,
                    "child"         => $request->child,
                    "infant"        => $request->infant,
                    "trainName"         => $request->trainName,
                    "departureStation"  => $request->departureStation,
                    "departureTime"     => $request->departureTime,
                    "arrivalStation"    => $request->arrivalStation,
                    "arrivalTime"       => $request->arrivalTime,
                    "priceAdult"        => $request->priceAdult,
                    "priceChild"        => $request->priceChild,
                    "priceInfant"       => $request->priceInfant,
                    "passengers"        => $request->passengers
                ]
            ];
        
            $client = new Client();
            $res = $client->post($key->api_url.'travel/train/train-book', $requestContent);
            $result = $res->getBody()->getContents();
            $res = json_decode($result);
            return $res;

        } catch (BadResponseException $ex) {
            $response = $ex->getResponse();
            $jsonBody = (string) $response->getBody();
            return json_decode($jsonBody);
        }
    }

    public function layoutSeat(Request $request)
    {
        try {
            $key = ApiKey::where('provider', 'KLICK')->first();
            $requestContent = [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                    'X-Signature'   => signKlik(),
                    'X-Api-Key'     => $key->key,
                    'Authorization' => 'Bearer '.$key->token,
                ],
                'json' => [
                    'origin'        => $request->origin,
                    'destination'   => $request->destination,
                    'date'          => $request->date,
                    "trainNumber"   => $request->train_number
                ]
            ];
        
            $client = new Client();
            $res = $client->post($key->api_url.'travel/train/seat-layout', $requestContent);
            $result = $res->getBody()->getContents();
            $res = json_decode($result);
            return $res;

        } catch (BadResponseException $ex) {
            $response = $ex->getResponse();
            $jsonBody = (string) $response->getBody();
            return json_decode($jsonBody);
        }
    }

    public function changeSeat(Request $request)
    {
        try {
            $key = ApiKey::where('provider', 'KLICK')->first();
            $requestContent = [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                    'X-Signature'   => signKlik(),
                    'X-Api-Key'     => $key->key,
                    'Authorization' => 'Bearer '.$key->token,
                ],
                'json' => [
                    'bookingCode'   => $request->booking_code,
                    'transactionId' => $request->transaction_id,
                    'wagonCode'     => $request->wagon_code,
                    "wagonNumber"   => $request->wagon_number,
                    "seats"         => $request->seats
                ]
            ];
        
            $client = new Client();
            $res = $client->post($key->api_url.'travel/train/change-seat', $requestContent);
            $result = $res->getBody()->getContents();
            $res = json_decode($result);
            return $res;

        } catch (BadResponseException $ex) {
            $response = $ex->getResponse();
            $jsonBody = (string) $response->getBody();
            return json_decode($jsonBody);
        }
    }

    public function paymentTrain(Request $request)
    {
        try {
            $key = ApiKey::where('provider', 'KLICK')->first();
            $requestContent = [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                    'X-Signature'   => signKlik(),
                    'X-Api-Key'     => $key->key,
                    'Authorization' => 'Bearer '.$key->token,
                ],
                'json' => [
                    'username'      => $key->merchant_id,
                    'bookingCode'   => $request->booking_code,
                    'transactionId' => $request->transaction_id,
                    'nominal'       => $request->nominal,
                    "nominal_admin" => 0,
                    "discount"      => 0
                ]
            ];
        
            $client = new Client();
            $res = $client->post($key->api_url.'travel/train/payment-train', $requestContent);
            $result = $res->getBody()->getContents();
            $res = json_decode($result);
            return $res;

        } catch (BadResponseException $ex) {
            $response = $ex->getResponse();
            $jsonBody = (string) $response->getBody();
            return json_decode($jsonBody);
        }
    }
}
