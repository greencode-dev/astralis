<?php

use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\CorpoCelesteController;
use App\Http\Controllers\Admin\CuriositaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleriaController;
use App\Http\Controllers\Admin\MissioneController;
use App\Http\Controllers\Admin\NasaImportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('guest');
})->name('home');

Route::redirect('/dashboard', '/admin')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware(['auth', 'verified', 'throttle:120,1'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categorie', CategoriaController::class)->parameters([
        'categorie' => 'categoria',
    ]);
    Route::post('corpi-celesti/suggest-nome', [CorpoCelesteController::class, 'suggestNome'])->middleware('throttle:30,1')->name('corpi-celesti.suggest-nome');
    Route::post('corpi-celesti/{corpoCeleste}/set-image/{galleriaCorpo}', [CorpoCelesteController::class, 'setImageFromGallery'])->name('corpi-celesti.set-image');
    Route::resource('corpi-celesti', CorpoCelesteController::class)->parameters([
        'corpi-celesti' => 'corpoCeleste',
    ]);
    Route::resource('missioni', MissioneController::class)->parameters([
        'missioni' => 'missione',
    ]);
    Route::resource('curiosita', CuriositaController::class)->parameters([
        'curiosita' => 'curiositum',
    ]);
    Route::resource('galleria', GalleriaController::class)->except(['show'])->parameters([
        'galleria' => 'galleriaCorpo',
    ]);
    Route::post('galleria/{galleriaCorpo}/ordine', [GalleriaController::class, 'aggiornaOrdine'])->name('galleria.ordine');
    Route::get('nasa-import', [NasaImportController::class, 'index'])->name('nasa-import.index');
    Route::post('nasa-import/import-all', [NasaImportController::class, 'importAll'])->name('nasa-import.import-all');
    Route::post('nasa-import/{corpoCeleste}', [NasaImportController::class, 'import'])->name('nasa-import.import');
});

require __DIR__.'/auth.php';

// Catch-all per SPA: deve stare DOPO tutte le route specifiche (auth comprese)
Route::get('/{any}', function () {
    return view('guest');
})->where('any', '.*');
