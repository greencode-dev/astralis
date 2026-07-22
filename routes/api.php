<?php
// API REST pubbliche — 10 endpoint JSON per React guest. Throttle 60 req/min

use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\CorpoCelesteController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\MissioneController;
use App\Http\Controllers\Api\CuriositaController;
use App\Http\Controllers\Api\GalleriaController;
use Illuminate\Support\Facades\Route;

// Throttle globale: 60 richieste/minuto per IP
Route::middleware('throttle:60,1')->group(function () {
    // Corpi Celesti: index (filtri+paginazione), show (per slug), simili (per categoria)
    Route::get('/corpi-celesti', [CorpoCelesteController::class, 'index']);
    Route::get('/corpi-celesti/{corpoCeleste:slug}', [CorpoCelesteController::class, 'show']);
    Route::get('/corpi-celesti/{corpoCeleste:slug}/simili', [CorpoCelesteController::class, 'simili']);

    // Categorie: index (tutte), show (per slug con corpiCelesti)
    Route::get('/categorie', [CategoriaController::class, 'index']);
    Route::get('/categorie/{categoria:slug}', [CategoriaController::class, 'show']);

    // Missioni: index (tutte), show (per slug con corpiCelesti)
    Route::get('/missioni', [MissioneController::class, 'index']);
    Route::get('/missioni/{missione:slug}', [MissioneController::class, 'show']);

    // Curiosità: index (tutte)
    Route::get('/curiosita', [CuriositaController::class, 'index']);
    // Galleria: index (tutte)
    Route::get('/galleria', [GalleriaController::class, 'index']);

    // Dashboard stats: conteggi per grafici React
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
});
