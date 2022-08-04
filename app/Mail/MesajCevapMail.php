<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MesajCevapMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $mesaj;
    public $cevap;
    public function __construct($mesaj,$cevap)
    {
        $this->mesaj = $mesaj;
        $this->cevap = $cevap;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $messageData = $this->mesaj;
        $cevapData = $this->cevap;
        return $this->subject($messageData['im_konu'])->view('back.mail.mesaj_cevap',compact('messageData','cevapData'));    }
}
