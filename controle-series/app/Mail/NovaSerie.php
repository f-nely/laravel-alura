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

    /**
     * @var string
     */
    public $nome;
    /**
     * @var Temporada
     */
    public $qtdTemporada;
    /**
     * @var Episodio
     */
    public $qtdEpisodios;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $nome, Temporada $qtdTemporada, Episodio $qtdEpisodios)
    {
        //
        $this->nome = $nome;
        $this->qtdTemporada = $qtdTemporada;
        $this->qtdEpisodios = $qtdEpisodios;
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
