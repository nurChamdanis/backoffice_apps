<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class HeaderKeyNoAuth
{
    public function handle(Request $request, Closure $next)
    {
        $corr = $request->header('A-Correlation-Id');
        $path = $request->header('X-Path');
        $phone = $request->phone;
        $phoneDecode = base64_decode($phone);

        if($path == 'resend-otp'){
            $string = base64_encode($phoneDecode.$corr);
        }else if($path == 'reset-pin') {
            $string = md5($phoneDecode.$corr.$request->otp.'reset-pin');
        }else if($path == 'reset-password') {
            $string = md5($phoneDecode.$corr.$request->otp.'reset-password');
        }else if($path == 'ubah-pin') {
            $string = md5($phoneDecode.$corr.$request->pin.'ubah-pin');
        }else if($path == 'ubah-password') {
            $string = md5($phoneDecode.$corr.$request->password.'ubah-password');
        }
        
        $sign = hash_hmac('sha256', $string, $corr);

        if (hash_equals($request->header('X-Signature'), $sign)) {
            return $next($request);
        } else {
            return response()->json([
                'error'     => true,
                'message'   => 'Invalid Signature!',
                'data'      => null
            ], 422);
        }
    }
}
