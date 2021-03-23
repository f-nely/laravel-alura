<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NovaSerie extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    public $nome;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $nome)
    {
        //
        $this->nome = $nome;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.serie.nova-serie');
    }
}
