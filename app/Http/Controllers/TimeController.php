<?php

namespace App\Http\Controllers;

use App\Models\Time;
use Illuminate\Http\Request;

class TimeController extends Controller
{
    
    public function store(Request $request)
    {
        try {
            $time = Time::create($request->all());

            return response()->json(['data' => $time]);
            
        } catch (\Exception $e) {
              return response()->json(['erro' => 'Ocorreu um erro ao criar o time. Detalhes: ' . $e->getMessage()], 500);
        }
    }

    public function index() 
    {
        $result = Time::all();

        return response()->json(['data' => $result]);
    }
}
