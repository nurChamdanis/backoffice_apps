<?php

namespace Modules\Wallet\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Wallet\App\Enums\Wallet;

class AuthController extends Controller
{

    public function __construct() {

    }

    public function createTokenB2b()
    {
        $time = date(Wallet::DATE_FORMAT);
        $strToSIgn = Wallet::CLIENT_KEY."|".$time;
        $sign = Wallet::generateSignature($strToSIgn, file_get_contents(base_path('private.pem')));
        $headers = [
            'Accept'            => 'application/json',
            'Content-Type'      => 'application/json',
            'X-Idempotency-Key' => Wallet::generateGuid(),
            'X-TIMESTAMP'       => $time,
            'X-SIGNATURE'       => $sign,
            'X-CLIENT-KEY'      => "bilpay_mobile_dev",
        ];

        $jsonPayload = json_encode([
            "grantType" => "client_credentials"
        ]);
        $response = Wallet::requestApi(Wallet::getApiUrl().'/v1.0/access-token/b2b', $headers, $jsonPayload);
        return json_decode($response);
    }

    public function createTokenB2b2c()
    {
        $time = date(Wallet::DATE_FORMAT);
        $strToSIgn = Wallet::CLIENT_KEY."|".$time;
        $sign = Wallet::generateSignature($strToSIgn, file_get_contents(base_path('private.pem')));
        $headers = [
            'Accept'            => 'application/json',
            'Content-Type'      => 'application/json',
            'X-Idempotency-Key' => Wallet::generateGuid(),
            'X-TIMESTAMP'       => $time,
            'X-SIGNATURE'       => $sign,
            'X-CLIENT-KEY'      => "bilpay_mobile_dev",
        ];

        $jsonPayload = json_encode([
            "grantType" => "client_credentials"
        ]);
        $response = Wallet::requestApi(Wallet::getApiUrl().'/v1.0/access-token/b2b2c', $headers, $jsonPayload);
        return json_decode($response);
    }

}
