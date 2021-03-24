<?php


namespace App\Http\Controllers;

use App\Events\NovaSerie;
use App\Http\Requests\SeriesFormRequest;
use App\Serie;
use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSerie;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        $series = Serie::query()->orderBy('nome')->get();

        $mensagem = $request->session()->get('mensagem');

        return view('series.index', compact('series', 'mensagem'));
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request, CriadorDeSerie $criadorDeSerie)
    {
        $serie = $criadorDeSerie->criarSerie(
            $request->nome,
            $request->qtd_temporadas,
            $request->ep_por_temporada
        );

        $eventoNovaSerie = new NovaSerie(
            $request->nome,
            $request->qtd_temporadas,
            $request->ep_por_temporada
        );
        event($eventoNovaSerie);

        $users = User::all();
        foreach ($users as $index => $user) {
            $multiplicador = $index + 1;
            $email = new \App\Mail\NovaSerie(
                $request->nome,
                $request->qtd_temporadas,
                $request->ep_por_temporada
            );
            $email->subject = 'Nova Série Adicionada';
            $when = now()->addSecond($multiplicador * 5);
            Mail::to($user)->later(
                $when,
                $email
            );
        }
        //dd($user);

        $request->session()->flash(
            'mensagem',
            "Série {$serie->id} e suas temporadas e episódios criados com sucesso {$serie->nome}"
        );

        return redirect()->route('listar_series');
    }

    public function destroy(Request $request, RemovedorDeSerie $removedorDeSerie)
    {
        $nomeSerie = $removedorDeSerie->removerSerie($request->id);
        $request->session()->flash(
            'mensagem',
            "Série $nomeSerie removida com sucesso"
        );

        return redirect()->route('listar_series');
    }

    public function editaNome(int $id ,Request $request)
    {
        $novoNome = $request->nome;
        $serie = Serie::find($id);
        $serie->nome = $novoNome;
        $serie->save();
    }
}
