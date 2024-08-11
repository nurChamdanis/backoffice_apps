<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class HeaderKeyApi
{
    public function handle(Request $request, Closure $next)
    {
        $string = stringToSignApi();
        $sign = hash_hmac('sha256', $string, $request->header('X-MemberId'));
        Log::info('SIGN '.$sign.' - SECRET KEY '.$request->header('X-MemberId'). $string);

        if ($request->header('X-Signature') == $sign) {
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
