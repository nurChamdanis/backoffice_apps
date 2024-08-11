<?php

use App\Providers\ComposerServiceProvider;
use App\Providers\MacroServiceProvider;
use Collective\Html\FormFacade;
use Collective\Html\HtmlFacade;
use Creativeorange\Gravatar\Facades\Gravatar;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;
use Intervention\Image\Facades\Image;
use jeremykenedy\Uuid\Uuid;
use Laravel\Socialite\Facades\Socialite;

return [


    'name' => env('APP_NAME', 'Laravel'),

    'env' => env('APP_ENV', 'production'),

    'debug' => (bool) env('APP_DEBUG', false),

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL', '/'),

    'timezone' => 'Asia/Jakarta',

    'locale' => 'en',

    'fallback_locale' => 'id',

    'faker_locale' => 'id_ID',

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    'maintenance' => [
        'driver' => 'file',
        // 'store'  => 'redis',
    ],

    'providers' => [

        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */
        Yajra\DataTables\DataTablesServiceProvider::class,
        Anhskohbo\NoCaptcha\NoCaptchaServiceProvider::class,
        Maatwebsite\Excel\ExcelServiceProvider::class,
        Spatie\Permission\PermissionServiceProvider::class,
        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        ComposerServiceProvider::class,
        MacroServiceProvider::class,
    ],

    'aliases' => Facade::defaultAliases()->merge([
        'Redis'     => Redis::class,
        'Form'      => FormFacade::class,
        'HTML'      => HtmlFacade::class,
        'Socialite' => Socialite::class,
        'Input'     => Input::class,
        'Gravatar'  => Gravatar::class,
        'Image'     => Image::class,
        'Uuid'      => Uuid::class,
        'NoCaptcha' => Anhskohbo\NoCaptcha\Facades\NoCaptcha::class,
        'Excel' => Maatwebsite\Excel\Facades\Excel::class,
    ])->toArray(),

];
