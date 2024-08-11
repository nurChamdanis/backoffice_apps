<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TransactionMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $produk;
    protected $data;
    public function __construct($user, $produk, $data)
    {
        $this->user = $user;
        $this->produk = $produk;
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: 'Transaksi '.$this->produk->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'admin::emails.trx',
            with: [
                'user'      => $this->user,
                'produk'    => $this->produk,
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
