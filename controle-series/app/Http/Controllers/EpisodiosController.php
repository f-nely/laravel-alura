<?php

namespace App\Http\Controllers;

use App\Episodio;
use App\Temporada;
use Illuminate\Http\Request;

class EpisodiosController extends Controller
{
    public function index(Temporada $temporada)
    {
        return view('episodios.index', [
            'episodios' => $temporada->episodios,
            'temporadaId' => $temporada->id
        ]);
    }

    public function assistir(Temporada $temporada, Request $request)
    {
        $episodiosAssistido = $request->episodios;
        $temporada->episodios->each(function (Episodio $episodio) use ($episodiosAssistido){
            $episodio->assistido = in_array(
                $episodio->id,
                $episodiosAssistido
            );
        });
        $temporada->push();
    }
}
