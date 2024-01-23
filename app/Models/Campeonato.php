<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class Campeonato extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];
    
    const FASES = [
        4 => 'Quartas de Final',
        2 => 'Semi-final',
        1 => 'Final'
    ];

    public function partidas()
    {
        return $this->hasMany(Partida::class);
    }

    public function getPartidas($idFase)
    {
        $partidas = $this->partidas()->with('time1','time2')->where('fase', $idFase)->get();

        return $partidas;
    }

    public function getFaseAtual()
    {   
        $fase = $this->partidas()->select('fase')->orderBy('fase', 'ASC')->first();
        
        if (empty($fase)) {
            return [
                'id' => 4,
                'nome' => self::FASES[4]
            ];
        }
      
        return [
            'id' => $fase->fase,
            'nome' => self::FASES[$fase->fase]
        ];
    }

    public function chavear()
    {      
        //se já existe partidas para essa chave, apenas retorna
        $partidas = $this->partidas;
        
        //primeira chave
        if ($partidas->isEmpty()) {
            $times = Time::all()->take(8);
        
            if (count($times) < 8) {
                throw new BadRequestException('Não é possível chavear um campeonato com menos de oito times');
            }
    
            $timesArray = $times->toArray();
            
            // Embaralhar os times
            shuffle($timesArray);
            
            for ($i = 0; $i < count($timesArray) - 1; $i += 2) {
                $partida = new Partida();
                $partida->time1_id = $timesArray[$i]['id'];
                $partida->time2_id = $timesArray[$i + 1]['id'];
                $partida->campeonato_id = $this->id;
                $partida->fase = count($times)/2;
                $partida->save();
            }

            return $this->partidas;
        }
        
        $partidasFaseAtual = $this->getPartidasFaseAtual();
        
        if (empty($partidasFaseAtual->first()->vencedor_id)) {
            throw new BadRequestException('Não é possível passar para a proxima fase sem terminar a atual');
        }
        
        $partidasFaseAtualArray = $partidasFaseAtual->toArray();
     
        for ($i = 0; $i < count($partidasFaseAtualArray) - 1; $i += 2) {
            $partida = new Partida();
            $partida->time1_id = $partidasFaseAtualArray[$i]['vencedor_id'];
            $partida->time2_id = $partidasFaseAtualArray[$i + 1]['vencedor_id'];
            $partida->campeonato_id = $this->id;
            $partida->fase = count($partidasFaseAtualArray)/2;
            $partida->save();
        }
    }

    public function simular()
    {
        $partidas = $this->getPartidasFaseAtual();
        
        if ($partidas->isEmpty()) {
            throw new BadRequestException('Fase não existe');
        }
        
        if (!empty($partidas->first()->id_vencedor)) {
            throw new BadRequestException('Fase já finalizada');
        }

        foreach($partidas as $partida) {
        
            $resultado = shell_exec('python3 /var/www/scripts/teste.py');
            $resultado = explode(',', $resultado);
            
            $gols1 = trim($resultado[0]);
            $gols2 = trim($resultado[1]);

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

    public function getPartidasFaseAtual()
    {   
        $fase = $this->getFaseAtual();
        $partidas = $this->partidas()->where('fase', $fase['id'])->get();

        return $partidas;
    }
}
