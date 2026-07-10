<?php

use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\CorpoCelesteController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\MissioneController;
use App\Http\Controllers\Api\CuriositaController;
use App\Http\Controllers\Api\GalleriaController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:60,1')->group(function () {
    Route::get('/corpi-celesti', [CorpoCelesteController::class, 'index']);
    Route::get('/corpi-celesti/{corpoCeleste:slug}', [CorpoCelesteController::class, 'show']);
    Route::get('/corpi-celesti/{corpoCeleste:slug}/simili', [CorpoCelesteController::class, 'simili']);

    Route::get('/categorie', [CategoriaController::class, 'index']);
    Route::get('/categorie/{categoria:slug}', [CategoriaController::class, 'show']);

    Route::get('/missioni', [MissioneController::class, 'index']);
    Route::get('/missioni/{missione:slug}', [MissioneController::class, 'show']);

    Route::get('/curiosita', [CuriositaController::class, 'index']);
    Route::get('/galleria', [GalleriaController::class, 'index']);

    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
});
