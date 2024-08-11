<?php

namespace App\Http\Middleware;

use App\Models\Membership;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekLimit
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $l = Membership::where('id', $user->plan_id)->first();

        $nom = intval($request->nominal);
        if ($nom <= $l->limit_transaction) {
            return $next($request);
        } else {
            return response()->json([[
                'status'    => false,
                'message'   => 'Limit maksimal Anda adalah '.rupiah($l->limit_transaction),
                'data'      => null
            ]]);
        }
    }
}
