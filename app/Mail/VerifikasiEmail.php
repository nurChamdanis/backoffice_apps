<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class VerifikasiEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $url;
    public function __construct($user, $url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: 'Verifikasi Email '.config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'admin::emails.verify',
            with: [
                'user'  => $this->user,
                'url'   => $this->url,
                'logo'  => getOss(bucketName().'/'.'php2A6F.tmp.png'),
                'app'   => config('app.name')
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
