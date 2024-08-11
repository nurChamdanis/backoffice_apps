<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TransferSaldoMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $data;
    public function __construct($user, $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: 'Transfer saldo '.config('app.name').' '.$this->data->status,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'admin::emails.trf_saldo',
            with: [
                'user'      => $this->user,
                'data'      => $this->data,
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
