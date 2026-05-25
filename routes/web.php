<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MusicianController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FollowController;

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


Route::middleware('auth')->group(function () {
    // ... tus rutas existentes ...

    Route::post('/follow/{user}',   [FollowController::class, 'send'])->name('follow.send');
    Route::post('/unfollow/{user}', [FollowController::class, 'unfollow'])->name('follow.unfollow');
    Route::post('/follow/{user}/accept', [FollowController::class, 'accept'])->name('follow.accept');
    Route::get('/following',        [FollowController::class, 'following'])->name('follow.following');
    Route::get('/follow/requests',  [FollowController::class, 'requests'])->name('follow.requests');
});

// Ver perfil público de un músico
Route::get('/musicians/{username}', [ProfileController::class, 'show'])->name('musician.show');


require __DIR__.'/auth.php';