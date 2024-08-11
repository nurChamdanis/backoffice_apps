<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OfficeDetect
{
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('X-IP', config('app.x_ip'));
        if ($request->ip() == config('app.x_ip')) {
            return $next($request);
        } else {
            return response()->json([
                'error'     => true,
                'message'   => 'Akses tidak di izinkan!',
                'data'      => null
            ]);
        }
    }

}
