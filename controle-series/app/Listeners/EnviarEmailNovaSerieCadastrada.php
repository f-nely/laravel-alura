<?php

namespace App\Listeners;

use App\Events\NovaSerie;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EnviarEmailNovaSerieCadastrada
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NovaSerie  $event
     * @return void
     */
    public function handle(NovaSerie $event)
    {
        $nomeSerie = $event->nomeSerie;
        $qtdTemporadas = $event->qtdTemporadas;
        $qtdEpisodios = $event->qtdEpisodios;
        $users = User::all();
        foreach ($users as $index => $user) {
            $multiplicador = $index + 1;
            $email = new \App\Mail\NovaSerie(
                $nomeSerie,
                $qtdTemporadas,
                $qtdEpisodios
            );
            $email->subject = 'Nova Série Adicionada';
            $when = now()->addSecond($multiplicador * 5);
            Mail::to($user)->later(
                $when,
                $email
            );
        }
    }
}
