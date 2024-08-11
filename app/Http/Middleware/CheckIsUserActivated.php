<?php

namespace App\Http\Middleware;

use App\Models\Activation;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Modules\Users\App\Models\Card;
use Symfony\Component\HttpFoundation\Response;

class CheckIsUserActivated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('settings.activation')) {
            $user = Auth::user();
            $currentRoute = Route::currentRouteName();
            $routesAllowed = [
                'authenticated.activate',
                'authenticated.activation-resend',
                'social/redirect/{provider}',
                'social/handle/{provider}',
                'logout',
            ];

            if (! in_array($currentRoute, $routesAllowed)) {
                if ($user && $user->activated != 1) {
                    Log::info('Non-activated user attempted to visit '.$currentRoute.'. ');
                    $response = [
                        'error'     => true,
                        'rc'        => '0015',
                        'message'   => 'Silahkan aktivasi akun Anda',
                        'route'     => 'VALIDASI_SCREEN',
                        'data'      => null,
                    ];
                
                    return response()->json([
                        $response
                    ], 406);
                }
            }

            if (in_array($currentRoute, $routesAllowed)) {
                if ($user && $user->activated == 1) {

                    $us = User::find($user->id);
                    $tokenResult = $us->createToken('authToken');
                    $token = $tokenResult->token;
                    $token->expires_at = Carbon::now()->addMinutes(30);
                    $token->save();
                    
                    $c = Card::where('user_id', $user->id)->first();

                    return response()->json([
                        'error'     => false,
                        'rc'        => '201',
                        'message'   => 'User Activated',
                        'memberId'  => $c->card_number,
                        'token'     => $tokenResult->accessToken,
                        'token_type' => 'Bearer',
                        'expires_at' => Carbon::parse(
                            $tokenResult->token->expires_at
                        )->toDateTimeString(),
                    ]);
                }

                if (! $user) {
                    Log::info('Non registered visit to '.$currentRoute.'. ');
                    return errorResponApi('Akun Anda tidak kami kenali', 422);
                }
            }
        }

        return $next($request);
    }
}
