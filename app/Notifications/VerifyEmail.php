<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Notification
{
    public static $createUrlCallback;
    public static $toMailCallback;

    protected $useEmail;
    public function __construct($useEmail)
    {
        $this->useEmail = $useEmail;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return $this->buildMailMessage($verificationUrl);
    }

    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject('Verifikasi Email '.config('app.name'))
            ->line('Silahkan klik tombol VERIFIKASI')
            ->action('VERIFIKASI', $url)
            ->line('Jika kamu tidak dapat verifikasi dengan tombol diatas silahkan ikuti link ini: ');
    }

    protected function verificationUrl($notifiable)
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable);
        }

        $strSign = $notifiable->getKey().$this->useEmail;
        return URL::temporarySignedRoute(
            'verification.email',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'sign' => hash_hmac('sha256', $strSign, $notifiable->getKey())
            ]
        );
    }

    public static function createUrlUsing($callback)
    {
        static::$createUrlCallback = $callback;
    }

    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
