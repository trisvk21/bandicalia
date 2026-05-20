<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MusicianController;
use Illuminate\Support\Facades\Route;

// Landing page (pública)
Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Buscador (requiere login)
Route::get('/home', [MusicianController::class, 'index'])
    ->middleware(['auth'])
    ->name('home');

// Dashboard tras login
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// Perfil propio (requiere login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
});

// Ver perfil público de un músico
Route::get('/musicians/{username}', [ProfileController::class, 'show'])->name('profile.show');

require __DIR__.'/auth.php';