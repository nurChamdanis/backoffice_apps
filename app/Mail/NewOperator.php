<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewOperator extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $pass;
    public function __construct($user, $pass)
    {
        $this->user = $user;
        $this->pass = $pass;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: 'Akun operator '.config('app.name').' baru ',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'admin::emails.operator',
            with: [
                'user'      => $this->user,
                'pass'      => $this->pass,
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
