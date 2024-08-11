<?php

namespace Modules\Gosms\App\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\Setting\App\Models\ApiKey;

class GosmsController extends Controller
{
    public function sendSMS($phone, $msg)
    {
        $key = ApiKey::where('provider', 'GOSMS')->first();
        $username = $key->username;
        $password = $key->key;

        $url = $key->api_url.'username='.$username.'&password='.$password.'&mobile='.$phone.'&message='.$msg;
        $client = new Client();
        $res = $client->get($url);
        $result = $res->getBody()->getContents();
        return $result;
    }
}
