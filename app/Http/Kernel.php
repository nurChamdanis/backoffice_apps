<?php

namespace App\Http;

use App\Http\Middleware\CheckIsUserActivated;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'office' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'activated' => [
            CheckIsUserActivated::class,
        ],
    ];

    protected $middlewareAliases = [
        'auth'              => \App\Http\Middleware\Authenticate::class,
        'auth.basic'        => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session'      => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers'     => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can'               => \Illuminate\Auth\Middleware\Authorize::class,
        'guest'             => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm'  => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed'            => \App\Http\Middleware\ValidateSignature::class,
        'throttle'          => \App\Http\Middleware\ThrottleRequests::class,
        'verified'          => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'activated'         => CheckIsUserActivated::class,
        'currentUser'       => \App\Http\Middleware\CheckCurrentUser::class,

        'frame' => \Illuminate\Http\Middleware\FrameGuard::class,
        'XSS' => \App\Http\Middleware\XSS::class,
        'sign.api' => \App\Http\Middleware\HeaderKeyApi::class,
        'sign.noauth' => \App\Http\Middleware\HeaderKeyNoAuth::class,
        'office' => \App\Http\Middleware\OfficeDetect::class,
        'admin' => \App\Http\Middleware\RedirectIfNotAdmin::class,
        'admin.guest' => \App\Http\Middleware\RedirectIfAdmin::class,
        'cutoff' => \App\Http\Middleware\MaintenanceMode::class,

        'cek.limit' => \App\Http\Middleware\CekLimit::class,

    ];
}
