<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KontakMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nama;
    public $email;
    public $telepon;
    public $subjek;
    public $pesan;

    public function __construct($nama, $email, $telepon, $subjek, $pesan)
    {
        $this->nama = $nama;
        $this->email = $email;
        $this->telepon = $telepon;
        $this->subjek = $subjek;
        $this->pesan = $pesan;
    }

    public function build()
    {
        return $this->subject('Pesan Baru dari Kontak Form: ' . $this->subjek)
                    ->view('emails.kontak');
    }
}
