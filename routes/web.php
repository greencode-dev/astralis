<?php

use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\CorpoCelesteController;
use App\Http\Controllers\Admin\CuriositaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleriaController;
use App\Http\Controllers\Admin\MissioneController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware(['auth', 'verified'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categorie', CategoriaController::class)->parameters([
        'categorie' => 'categoria',
    ]);
    Route::resource('corpi-celesti', CorpoCelesteController::class)->parameters([
        'corpi-celesti' => 'corpoCeleste',
    ]);
    Route::resource('missioni', MissioneController::class)->parameters([
        'missioni' => 'missione',
    ]);
    Route::resource('curiosita', CuriositaController::class)->except(['show'])->parameters([
        'curiosita' => 'curiositum',
    ]);
    Route::resource('galleria', GalleriaController::class)->except(['show'])->parameters([
        'galleria' => 'galleriaCorpo',
    ]);
});

require __DIR__.'/auth.php';
