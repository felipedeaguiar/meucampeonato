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

        return response()->json(['data' => $campeonato->getPartidas($fase)]);
    }
    
    public function store(Request $request)
    {
        try {
            $time = Campeonato::create($request->all());

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

    public function iniciar(int $id)
    {
        $campeonato = Campeonato::find($id);

        if (empty($campeonato)) {
            return response()->json(['erro' => 'Não possível iniciar o campeonato pois ele não existe'], 404);
        }
        
        $times = Time::all();

        if (count($times) < 8) {
            return response()->json(['erro' => 'Não é possível iniciar um campeonato com menos de oito times'], 403);
        }

        $timesArray = $times->toArray();

        // Embaralhar os times
        shuffle($timesArray);
        
        for ($i = 0; $i < count($timesArray) - 1; $i += 2) {
            $partida = new Partida();
            $partida->time1_id = $timesArray[$i]['id'];
            $partida->time2_id = $timesArray[$i + 1]['id'];
            $partida->campeonato_id = $campeonato->id;
            $partida->fase = 4;
            $partida->save();
        }


        foreach ($campeonato->partidas as $partida) {
            $gols1 = rand(0, 8);
            $gols2 = rand(0, 8);

            $partida->time1_placar = $gols1;
            $partida->time2_placar = $gols2;
           
            if ($gols1 > $gols2) {
                $partida->vencedor_id = $partida->time1_id;
            } else if ($gols1 < $gols2) {
                $partida->vencedor_id = $partida->time2_id;
            } else {
                if ($partida->time1->created_at > $partida->time2->created_at) {
                    $partida->vencedor_id = $partida->time1_id;
                }else {
                    $partida->vencedor_id = $partida->time2_id;
                }
            }

            $partida->save();
        }

        $vencedoresFase = $campeonato->partidas->where('fase', 4)->toArray();
        
        for ($i = 0; $i < count($vencedoresFase) - 1; $i += 2) {
            $partida = new Partida();
            $partida->time1_id = $vencedoresFase[$i]['vencedor_id'];
            $partida->time2_id = $vencedoresFase[$i + 1]['vencedor_id'];
            $partida->campeonato_id = $campeonato->id;
            $partida->fase = 2;
            $partida->save();
        }

        foreach ($campeonato->partidas()->where('fase', 2)->get() as $partida) {
            $gols1 = rand(0, 8);
            $gols2 = rand(0, 8);

            $partida->time1_placar = $gols1;
            $partida->time2_placar = $gols2;
           
            if ($gols1 > $gols2) {
                $partida->vencedor_id = $partida->time1_id;
            } else if ($gols1 < $gols2) {
                $partida->vencedor_id = $partida->time2_id;
            } else {
                if ($partida->time1->created_at > $partida->time2->created_at) {
                    $partida->vencedor_id = $partida->time1_id;
                }else {
                    $partida->vencedor_id = $partida->time2_id;
                }
            }

            $partida->save();
        }

        $vencedoresFase = $campeonato->partidas()->where('fase', 2)->get()->toArray();
      
        for ($i = 0; $i < count($vencedoresFase) - 1; $i += 2) {
            $partida = new Partida();
            $partida->time1_id = $vencedoresFase[$i]['vencedor_id'];
            $partida->time2_id = $vencedoresFase[$i + 1]['vencedor_id'];
            $partida->campeonato_id = $campeonato->id;
            $partida->fase = 1;
            $partida->save();
        }

        foreach ($campeonato->partidas()->where('fase', 1)->get() as $partida) {
            $gols1 = rand(0, 8);
            $gols2 = rand(0, 8);

            $partida->time1_placar = $gols1;
            $partida->time2_placar = $gols2;
           
            if ($gols1 > $gols2) {
                $partida->vencedor_id = $partida->time1_id;
            } else if ($gols1 < $gols2) {
                $partida->vencedor_id = $partida->time2_id;
            } else {
                if ($partida->time1->created_at > $partida->time2->created_at) {
                    $partida->vencedor_id = $partida->time1_id;
                }else {
                    $partida->vencedor_id = $partida->time2_id;
                }
            }

            $partida->save();
        }
    }
}
