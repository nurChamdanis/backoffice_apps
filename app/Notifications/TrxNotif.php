<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;

class TrxNotif extends Notification
{
    use Queueable;

    protected $title;
    protected $message;
    protected $image;
    protected $fcmTokens;
    protected $type;


    public function __construct($title, $message, $image, $fcmTokens, $type)
    {
        $this->title     = $title;
        $this->message   = $message;
        $this->image     = $image;
        $this->fcmTokens = $fcmTokens;
        $this->type      = $type;

    }

    public function via($notifiable)
    {
        return ['firebase'];
    }

    public function toFirebase($notifiable)
    {
        return (new FirebaseMessage)
            ->withTitle($this->title)
            ->withBody($this->message)
            ->withImage($this->image)
            ->withAdditionalData(array('title' => $this->title, 'body' => $this->message, 'type' => $this->type))
            ->withPriority('high')->asNotification($this->fcmTokens);
    }
}
