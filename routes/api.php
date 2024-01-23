<?php

use App\Http\Controllers\CampeonatoController;
use App\Http\Controllers\TimeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/time', [TimeController::class, 'store']);
Route::get('/time', [TimeController::class, 'index']);
Route::post('/campeonato', [CampeonatoController::class, 'store']);
Route::get('/campeonato', [CampeonatoController::class, 'index']);
Route::get('/campeonato/{id}', [CampeonatoController::class, 'show']);
Route::get('/campeonato/{id}/fase-atual', [CampeonatoController::class, 'faseAtual']);
Route::post('/campeonato/{id}/iniciar', [CampeonatoController::class, 'iniciar']);
Route::post('/campeonato/{id}/chavear', [CampeonatoController::class, 'chavear']);
Route::post('/campeonato/{id}/simular', [CampeonatoController::class, 'simular']);
Route::get('/campeonato/{id}/partidas/{fase}', [CampeonatoController::class, 'partidas']);



