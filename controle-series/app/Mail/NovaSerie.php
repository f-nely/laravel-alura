<?php

namespace App\Mail;

use App\Episodio;
use App\Temporada;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NovaSerie extends Mailable
{
    use Queueable, SerializesModels;

    public $nome;

    public $qtdTemporadas;

    public $qtdEpisodios;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nome, $qtdTemporadas, $qtdEpisodios)
    {
        //
        $this->nome = $nome;
        $this->qtdTemporadas = $qtdTemporadas;
        $this->qtdEpisodios = $qtdEpisodios;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.serie.nova-serie');
    }
}
