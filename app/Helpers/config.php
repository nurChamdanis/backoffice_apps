<?php

use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Modules\Setting\App\Models\ApiKey;
use OSS\OssClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Produk\App\Models\Produk;
use Modules\Setting\App\Models\Setting;
use Modules\Transaksi\App\Models\KodeUnik;
use Modules\Transaksi\App\Models\Transaksi;
use Modules\Users\App\Models\Card;
use Modules\Users\App\Models\Notifikasi;
use Modules\Users\App\Models\PaymentMethod;

function userId()
{
    return Auth::user()->id;
}

function logo()
{
    $lg = asset('images/logo.png');

    return $lg;
}

function logoRed()
{
    $lg = asset('images/logo_red.png');

    return $lg;
}

function favicon()
{
    $fv = asset('images/favicon.ico');
    return $fv;
}

function invoice()
{
    $no = 1000000000;
    $inv = Transaksi::max('invoice');
    if ($inv) {
        $invoice = $inv + 1;
        return $invoice;
    } else {
        return $no;
    }
}

function minimalTopup()
{
    $d = 9999;
    return $d;
}

function maximalTopup()
{
    $d = 250000000;
    return $d;
}

function limitTransaksi()
{
    $us = User::where('id', userId())->first();
    $m = Membership::where('id', $us->plan_id)->first();
    $limit = $m->limit_transaction;
    return $limit;
}

function biayaTransfer()
{
    $val = Setting::where('key', 'Biaya Transfer')->first();
    if(!isset($val)){
        return response()->json([
            'error'   => true,
            "message" => 'Settings variable failed (errCode:0031)'
        ], 429);
    }
    $adm = json_decode($val->value);
    $fee = $adm->biaya;

    return $fee;
}

function biayaDeposit($code)
{
    $val = PaymentMethod::where('code', $code)->first();
    $fee = intval($val->fee);
    return $fee;
}

function  uniqueCode()
{
    $random_number = rand(111, 999);
    $checkIfExist = checkIfExist($random_number);
    while ($checkIfExist) {
        return $random_number;
    }
}

function checkIfExist($unique_number)
{
    $check_unique = KodeUnik::where([
        'code' => $unique_number,
    ])->whereDate('created_at', '=', Carbon::today()->toDateString())->first();

    if (!$check_unique) {
        return true;
    } else {
        return false;
    }
}

function rupiah($angka)
{
    $hasil_rupiah = number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

function errorResponApi($message, $errorCode = 422)
{
    $response = [
        'status' => false,
        'message' => $message,
        'data' => null,
    ];

    return response()->json([
        $response
    ], $errorCode);
}

function successResponse($message, $data = null)
{

    if ($message == null) {
        $message = 'Success';
    }

    $response = [
        'status' => true,
        'message' => $message,
        'data' => $data,
    ];

    return response()->json([
        $response
    ], 200);
}

function getOss($file)
{
    $k = ApiKey::where('provider', 'OSS')->first();
    
    $oss = new OssClient($k->key, $k->secret, $k->api_url);
    $timeout = 3600;
    $options = [$oss->setUseSSL(true)];
    $upload = $oss->signUrl($k->username, $file, $timeout, "GET", $options);
    return $upload;
}

function publicUpload($object, $filePath)
{
    $k = ApiKey::where('provider', 'OSS')->first();
    $oss = new OssClient($k->key, $k->secret, $k->api_url);
    $upload = $oss->uploadFile($k->username, $object, $filePath);
    return $upload;
}

function bucketName()
{
    $k = ApiKey::where('provider', 'OSS')->first();
    return $k->merchant_id;
}

function signKlik()
{
    $k = ApiKey::where('provider', 'KLICK')->first();
    $sign = hash_hmac('sha256', $k->key, $k->merchant_id);
    return $sign;
}

function createAuthKlik()
{
    $key = ApiKey::where('provider', 'KLICK')->first();
    $requestContent = [
        'headers' => [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json'
        ],
        'json' => [
            'phone' => $key->phone,
            'password' => $key->username
        ]
    ];

    $client = new Client();
    $res = $client->post($key->api_url.'authenticate', $requestContent);
    $result = $res->getBody()->getContents();
    $res = json_decode($result);
    $token = $res[0]->data;

    $key->token = $token;
    $key->save();
    
    Log::info('AUTH TOKEN KLIK DI PROSES');
    return $token;
}

function stringToSignApi()
{
    $user = User::find(userId());
    $card = Card::where('user_id', userId())->first();
    return base64_encode($user->phone.$card->card_number);
}

function stringToSignApiNoAuth($card)
{
    try {
        $card = Card::where('card_number', $card)->first();
        $user = User::where('id', $card->user_id)->first();
        return base64_encode($user->phone.$card->card_number);
    } catch (\Throwable $th) {
        return response()->json([
            'error'     => true,
            'message'   => 'Invalid Signature!',
            'data'      => null
        ], 422);
    }
}

function signNukar()
{
    $k = ApiKey::where('provider', 'NUKAR')->first();
    $strTosign = $k->username.$k->key.$k->secret;
    $sign = hash_hmac('sha256', $strTosign, $k->secret);
    return $sign;
}

function createAuthNukar()
{
    $key = ApiKey::where('provider', 'NUKAR')->first();
    $requestContent = [
        'headers' => [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'X-IP'          => $key->ip_address
        ],
        'json' => [
            'phone' => $key->username,
            'sign'  => signNukar()
        ]
    ];

    $client = new Client();
    $res = $client->post($key->api_url.'sign-in', $requestContent);
    $result = $res->getBody()->getContents();
    $res = json_decode($result);
    $token = $res->token;

    $key->token = $token;
    $key->save();
    
    Log::info('AUTH TOKEN NUKAR DI PROSES');
    return $token;
}

function signatureKey()
{
    $k = ApiKey::where('provider', 'NUKAR')->first();
    $strKey = $k->email.$k->phone.$k->merchant_id;
    $strToSign = $strKey.$k->merchant_id;
    $sign = hash_hmac('sha256', $strToSign, $k->merchant_id);

    return $sign;
}

function detailNukar()
{
    $key = ApiKey::where('provider', 'NUKAR')->first();
    $requestContent = [
        'headers' => [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'User-Agent'    => 'okhttp/4.9.1',
            'X-MerchantId'  => $key->merchant_id,
            'X-Signature'   => signatureKey(),
            'X-Key-Devices' => 'mE6kaz2dxNCxDFenS8tgBzjwysVmPsS6b7f33bd410c0cc4e4e739ee66b80388ahgav5PsYwSDGhdFn7YjnhC9rwSZPDXQt',
            'Authorization' => 'Bearer '.$key->token
        ]
    ];

    $client = new Client();
    $res = $client->post($key->api_url.'user-detail', $requestContent);
    $result = $res->getBody()->getContents();
    $res = json_decode($result);

    return $res;
}

function getPrabayar()
{
    $key = ApiKey::where('provider', 'NUKAR')->first();
    $requestContent = [
        'headers' => [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'User-Agent'    => 'okhttp/4.9.1',
            'X-MerchantId'  => $key->merchant_id,
            'X-Signature'   => signatureKey(),
            'Authorization' => 'Bearer '.$key->token
        ]
    ];

    $client = new Client();
    $res = $client->post($key->api_url.'produk/all-prabayar', $requestContent);
    $result = $res->getBody()->getContents();
    $res = json_decode($result);

    return $res;
}

function getPasca()
{
    $key = ApiKey::where('provider', 'NUKAR')->first();
    $requestContent = [
        'headers' => [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'User-Agent'    => 'okhttp/4.9.1',
            'X-MerchantId'  => $key->merchant_id,
            'X-Signature'   => signatureKey(),
            'Authorization' => 'Bearer '.$key->token
        ]
    ];

    $client = new Client();
    $res = $client->post($key->api_url.'produk/all-pascabayar', $requestContent);
    $result = $res->getBody()->getContents();
    $res = json_decode($result);

    return $res;
}

function urlTrxNukar($code, $idPel)
{
    $key = ApiKey::where('provider', 'NUKAR')->first();
    $requestContent = [
        'headers' => [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'User-Agent'    => 'okhttp/4.9.1',
            'X-MerchantId'  => $key->merchant_id,
            'X-Signature'   => signatureKey(),
            'Authorization' => 'Bearer '.$key->token
        ],
        'json' => [
            'code'          => $code,
            'id_pelanggan'  => $idPel,
            'pin'           => '000000',
            'pay_method'    => 100,
            'secret'        => $key->secret
        ]
    ];

    $client = new Client();
    $res = $client->post($key->api_url.'transaksi/transaksi-prabayar', $requestContent);
    $result = $res->getBody()->getContents();
    $res = json_decode($result);

    Log::info('TRANSAKSI DI PROSES');
    return $res;
}

function urlInquiryNukar($code, $idPel)
{
    $key = ApiKey::where('provider', 'NUKAR')->first();
    $requestContent = [
        'headers' => [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'User-Agent'    => 'okhttp/4.9.1',
            'X-MerchantId'  => $key->merchant_id,
            'X-Signature'   => signatureKey(),
            'Authorization' => 'Bearer '.$key->token
        ],
        'json' => [
            'code'          => $code,
            'id_pelanggan'  => $idPel,
        ]
    ];

    $client = new Client();
    $res = $client->post($key->api_url.'transaksi/inquiry', $requestContent);
    $result = $res->getBody()->getContents();
    $res = json_decode($result);

    Log::info('INQUIRY DI PROSES');
    return $res;
}

function cekIdPln($idPel)
{
    $key = ApiKey::where('provider', 'NUKAR')->first();
    $requestContent = [
        'headers' => [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'User-Agent'    => 'okhttp/4.9.1',
            'X-MerchantId'  => $key->merchant_id,
            'X-Signature'   => signatureKey(),
            'Authorization' => 'Bearer '.$key->token
        ],
        'json' => [
            'id_pel'  => $idPel,
        ]
    ];

    $client = new Client();
    $res = $client->post($key->api_url.'transaksi/inquiry-pln', $requestContent);
    $result = $res->getBody()->getContents();
    $res = json_decode($result);

    return $res;
}

function urlTrxPascaNukar($refId)
{
    try {
        //code...
        $key = ApiKey::where('provider', 'NUKAR')->first();
        $requestContent = [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'User-Agent'    => 'okhttp/4.9.1',
                'X-MerchantId'  => $key->merchant_id,
                'X-Signature'   => signatureKey(),
                'Authorization' => 'Bearer '.$key->token
            ],
            'json' => [
                'ref_id'        => $refId,
                'pin'           => $key->pin,
            ]
        ];
    
        $client = new Client();
        $res = $client->post($key->api_url.'transaksi/transaksi-pascabayar', $requestContent);
        $result = $res->getBody()->getContents();
        $res = json_decode($result);
    
        Storage::disk('public')->put('transaksi-pascabayar.json', json_encode($res));
        return [$res];
        
    } catch (BadResponseException $ex) {

        $response = $ex->getResponse();
        $jsonBody = (string) $response->getBody();
        $data = json_decode($jsonBody);

        return response()->json(['data' => $data]);
    }

}

function cekStatusNukar($ref_id)
{
    $key = ApiKey::where('provider', 'NUKAR')->first();
    $requestContent = [
        'headers' => [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'User-Agent'    => 'okhttp/4.9.1',
            'X-MerchantId'  => $key->merchant_id,
            'X-Signature'   => signatureKey(),
            'Authorization' => 'Bearer '.$key->token
        ]
    ];

    $client = new Client();
    $res = $client->post($key->api_url.'transaksi/cek-status-trx/'.$ref_id, $requestContent);
    $result = $res->getBody()->getContents();
    $res = json_decode($result);

    return $res;
}

function listBank()
{
    $key = ApiKey::where('provider', 'NUKAR')->first();
    $requestContent = [
        'headers' => [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'User-Agent'    => 'okhttp/4.9.1',
            'X-MerchantId'  => $key->merchant_id,
            'X-Signature'   => signatureKey(),
            'Authorization' => 'Bearer '.$key->token
        ]
    ];

    $client = new Client();
    $res = $client->post($key->api_url.'disburse/bank-disburse', $requestContent);
    $result = $res->getBody()->getContents();
    $res = json_decode($result);

    return $res;
}

function beneficiaryNukar($code, $nominal, $tujuan, $note)
{
    $key = ApiKey::where('provider', 'NUKAR')->first();
    $requestContent = [
        'headers' => [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'User-Agent'    => 'okhttp/4.9.1',
            'X-MerchantId'  => $key->merchant_id,
            'X-Signature'   => signatureKey(),
            'Authorization' => 'Bearer '.$key->token
        ],
        'json' => [
            'kodeBank'  => $code,
            'nominal'   => $nominal,
            'tujuan'    => $tujuan,
            'note'      => $note,
        ]
    ];

    $client = new Client();
    $res = $client->post($key->api_url.'instan-transfer/beneficiary-account', $requestContent);
    $result = $res->getBody()->getContents();
    $res = json_decode($result);

    return $res;
}

function sendWA($to, $content)
{
    $key = ApiKey::where('provider', 'ZUWINDA')->first();
    $requestContent = [
        'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'x-access-key' => $key->secret
        ],
        'json' => [
            'instances_id' => $key->key,
            'content' => $content,
            'to' => $to
        ]
    ];
    $client = new Client;
    $res = $client->post($key->api_url . 'message/whatsapp/send-text', $requestContent);
    $result = $res->getBody()->getContents();
    return json_decode($result);
}

function allNotif()
{
    $dateS = Carbon::now()->startOfMonth();
    $dateE = Carbon::now()->endOfMonth();

    $d = Notifikasi::whereBetween('created_at',[$dateS, $dateE])->orderBy('id', 'desc')->limit(15)->get();
    return $d;
}

function autoRenameProduk()
{
    $set = Setting::where('key', 'set_produk')->first();
    if(isset($set)){
        $val = $set->value;
    }else {
        $val = 'off';
    }

    return $val;
}

function cekPromo($id)
{
    $p = Produk::where('code', $id)->first();
    if(isset($p)){
        $val = $p->is_promo;
    }else {
        $val = false;
    }

    return $val;
}

function cekPoinProduk($id)
{
    $p = Produk::where('code', $id)->first();
    if(isset($p)){
        $val = $p->poin;
    }else {
        $val = 0;
    }

    return $val;
}