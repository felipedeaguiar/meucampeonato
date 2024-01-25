<?php

namespace App\Http\Controllers;

use App\Models\Campeonato;
use App\Models\Partida;
use App\Models\Time;
use Illuminate\Http\Request;

class CampeonatoController extends Controller
{

    public function index()
    {
        $result = Campeonato::all();

        foreach ($result as $campeonato) {
            $campeonato['fases'] = $campeonato->getNavegacaoFases();
        }

        return response()->json(['data' => $result]);
    }

    public function show($id)
    {
        $result = Campeonato::find($id)->with('partidas')->first();

        if (empty($result)) {
            return response()->json(['erro' => 'Campeonato não encontrado!'], 404);
        }

        return response()->json(['data' => $result]);
    }

    public function partidas(int $campeonato, int $fase)
    {
         $campeonato = Campeonato::find($campeonato);

        if (empty($campeonato)) {
            return response()->json(['erro' => 'Campeonato não encontrado!'], 404);
        }

        $result = $campeonato->getPartidas($fase);

        $campeonato->fases = $campeonato->getNavegacaoFases();

        return response()->json(['data' => ['campeonato' => $campeonato, 'partidas' => $result]]);
    }

    public function store(Request $request)
    {
        try {
            $time = Campeonato::create($request->all());
            $time->fases = $time->getNavegacaoFases();

            return response()->json(['data' => $time]);

        } catch (\Exception $e) {
              return response()->json(['erro' => 'Ocorreu um erro ao criar o campeonato. Detalhes: ' . $e->getMessage()], 500);
        }
    }

    public function faseAtual($id)
    {
        $campeonato = Campeonato::find($id);

        if (empty($campeonato)) {
            return response()->json(['erro' => 'Campeonato não encontrado!'], 404);
        }

        return response()->json(['data' => $campeonato->getFaseAtual()]);
    }

    public function chavear(int $id)
    {
        $campeonato = Campeonato::find($id);

        if (empty($campeonato)) {
            return response()->json(['erro' => 'Não possível chavear a fase pois o campeonato não existe'], 404);
        }

        try {
            $result = $campeonato->chavear();

            return response()->json(['data' => $result]);

        } catch (\Exception $e) {
              return response()->json(['erro' => 'Ocorreu um erro ao chavear fase. Detalhes: ' . $e->getMessage()], 500);
        }
    }

    public function simular(int $id)
    {
        $campeonato = Campeonato::find($id);

        if (empty($campeonato)) {
            return response()->json(['erro' => 'Não possível chavear a fase pois o campeonato não existe'], 404);
        }

        try {
            $result = $campeonato->simular();

            return response()->json(['data' => $result]);

        } catch (\Exception $e) {
              return response()->json(['erro' => 'Ocorreu um erro ao chavear fase. Detalhes: ' . $e->getMessage()], 500);
        }
    }
}
