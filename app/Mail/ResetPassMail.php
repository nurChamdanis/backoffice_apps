<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPassMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: 'Resert Kata Sandi '.config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'admin::emails.reset_pass',
            with: [
                'user'      => $this->user,
                'logo'      => getOss(bucketName().'/'.'php2A6F.tmp.png'),
                'app'       => config('app.name')
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
