<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;


    public function time1()
    {
        return $this->hasOne(Time::class, 'id', 'time1_id');
    }

    public function time2()
    {
        return $this->hasOne(Time::class, 'id', 'time2_id');
    }
}
