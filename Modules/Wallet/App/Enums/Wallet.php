<?php

namespace Modules\Wallet\App\Enums;

class Wallet
{
    public static $isProduction = false;
    public static $apiUrl = "";

    const SANDBOX_API_URL = "http://sandbox.api.bilpay.id";
    const PRODUCTION_API_URL = "https://api.bilpay.id";
    const CLIENT_KEY = "bilpay_mobile_dev";
    const DATE_FORMAT = "Y-m-d\TH:i:sP";

    public static function getApiUrl()
    {
        if (!self::$isProduction && !empty(self::$apiUrl)) {
            return self::$apiUrl;
        }
        return self::$isProduction ?
        self::PRODUCTION_API_URL : self::SANDBOX_API_URL;
    }

    public static function generateSignature($data, $key)
    {
        $signature = '';
        openssl_sign($data, $signature, $key, OPENSSL_ALGO_SHA256);
  
        return base64_encode($signature);
    }

    public static function getDateNow()
    {
        return date(self::DATE_FORMAT);
    }

    public static function generateGuid()
    {
        if (function_exists('com_create_guid') === true)
            return trim(com_create_guid(), '{}');

        $data    = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public static function requestApi($url, $headers, $jsonPayload)
    {

        $curl = curl_init();
        $opts = [
            CURLOPT_URL            =>  $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $jsonPayload,
            CURLOPT_HTTPHEADER     => $headers
        ];

        curl_setopt_array($curl, $opts);

        $response = curl_exec($curl);
        $err      = curl_error($curl);

        curl_close($curl);

        if ($err) {
            die("Request Error #:" . $err);
        }

        return $response;
    }

    public static function sanitizePhone($phone)
    {
        $phone = preg_replace('/\s/', '', $phone);
  
        if (strpos($phone, '062+8') === 0) {
            $suffix    = substr($phone, strlen('062+8'));
            $sanitized = '062+8' . preg_replace('/\D/', '', $suffix);
        } else {
            $sanitized = preg_replace('/\D/', '', $phone);
        }
  
        return $sanitized;
    }
}