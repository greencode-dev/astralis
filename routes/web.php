<?php
// Route admin (Blade+auth) + catch-all SPA React. Gruppo prefix('admin') con middleware auth+throttle

use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\CorpoCelesteController;
use App\Http\Controllers\Admin\CuriositaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleriaController;
use App\Http\Controllers\Admin\MissioneController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\NasaImportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('guest');
})->name('home');

Route::redirect('/dashboard', '/admin')->name('dashboard');

// Blocco profilo: 3 route protette da middleware auth (edit, update, destroy)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Blocco admin: prefix admin + auth + verified + throttle 120/min
Route::prefix('admin')->middleware(['auth', 'verified', 'throttle:120,1'])->name('admin.')->group(function () {
    // Dashboard admin (stat card + grafici)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // CRUD Categorie: resource (index, create, store, show, edit, update, destroy)
    Route::resource('categorie', CategoriaController::class)->parameters([
        'categorie' => 'categoria',
    ]);
    // NASA suggest: debounce 30/min, traduce IT→EN per auto-fill nome inglese
    Route::post('corpi-celesti/suggest-nome', [CorpoCelesteController::class, 'suggestNome'])->middleware('throttle:30,1')->name('corpi-celesti.suggest-nome');
    // Gallery add: aggiunge immagine alla galleria (URL remoto)
    Route::post('corpi-celesti/{corpoCeleste}/gallery-add', [CorpoCelesteController::class, 'galleryAdd'])->name('corpi-celesti.gallery-add');
    // Set image: imposta immagine dalla galleria come principale
    Route::post('corpi-celesti/{corpoCeleste}/set-image/{galleriaCorpo}', [CorpoCelesteController::class, 'setImageFromGallery'])->name('corpi-celesti.set-image');
    // CRUD Corpi Celesti: resource con parametri personalizzati
    Route::resource('corpi-celesti', CorpoCelesteController::class)->parameters([
        'corpi-celesti' => 'corpoCeleste',
    ]);
    // CRUD Missioni: resource
    Route::resource('missioni', MissioneController::class)->parameters([
        'missioni' => 'missione',
    ]);
    // CRUD Curiosità: resource con parametri personalizzati
    Route::resource('curiosita', CuriositaController::class)->parameters([
        'curiosita' => 'curiositum',
    ]);
    // CRUD Galleria: resource senza show (gestita da CorpoCeleste show)
    Route::resource('galleria', GalleriaController::class)->except(['show'])->parameters([
        'galleria' => 'galleriaCorpo',
    ]);
    // Ordine galleria: aggiorna ordinamento immagini
    Route::post('galleria/{galleriaCorpo}/ordine', [GalleriaController::class, 'aggiornaOrdine'])->name('galleria.ordine');
    // Exam dashboard: quick reference per l'esame
    Route::get('exam', [ExamController::class, 'index'])->name('exam');
    // NASA import: index, import-all, import single
    Route::get('nasa-import', [NasaImportController::class, 'index'])->name('nasa-import.index');
    Route::post('nasa-import/import-all', [NasaImportController::class, 'importAll'])->name('nasa-import.import-all');
    Route::post('nasa-import/{corpoCeleste}', [NasaImportController::class, 'import'])->name('nasa-import.import');
});

// Auth routes: Breeze (login, register, password, email verification)
require __DIR__.'/auth.php';

// Catch-all SPA: qualsiasi route non matchata → React, DEVE stare in fondo
Route::get('/{any}', function () {
    return view('guest');
})->where('any', '.*');
