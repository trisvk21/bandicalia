<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MusicianController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FollowController;

// Landing page (pública)
Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Elección de tipo de cuenta
Route::get('/register', function () {
    return view('auth.choose-type');
})->name('register');

Route::get('/register/musician', [RegisteredUserController::class, 'create'])
    ->name('register.musician');

Route::get('/register/band', [RegisteredUserController::class, 'createBand'])
    ->name('register.band');

Route::post('/register/musician', [RegisteredUserController::class, 'store'])
    ->name('register.musician.store');

Route::post('/register/band', [RegisteredUserController::class, 'storeBand'])
    ->name('register.band.store');

Route::post('/follow/{user}/reject', [FollowController::class, 'reject'])->name('follow.reject');

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
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/ads/create', [AdController::class, 'create'])->name('ads.create');
    Route::post('/ads', [AdController::class, 'store'])->name('ads.store');
    Route::delete('/ads/{ad}', [AdController::class, 'destroy'])->name('ads.destroy');

    //Onboarding
    Route::get('/onboarding', [App\Http\Controllers\OnboardingController::class, 'show'])->name('onboarding.show');
    Route::post('/onboarding', [App\Http\Controllers\OnboardingController::class, 'store'])->name('onboarding.store');
});

Route::middleware('auth')->group(function () {
    // ... tus rutas existentes ...

    Route::post('/follow/{user}',   [FollowController::class, 'send'])->name('follow.send');
    Route::post('/unfollow/{user}', [FollowController::class, 'unfollow'])->name('follow.unfollow');
    Route::post('/follow/{user}/accept', [FollowController::class, 'accept'])->name('follow.accept');
    Route::get('/following',        [FollowController::class, 'following'])->name('follow.following');
    Route::get('/follow/requests',  [FollowController::class, 'requests'])->name('follow.requests');
    Route::get('/ads', [AdController::class, 'index'])->name('ads.index');
    Route::get('/ads/{ad}', [AdController::class, 'show'])->name('ads.show');
    Route::post('/ads/{ad}/apply', [AdController::class, 'apply'])->name('ads.apply');
    Route::get('/ads/{ad}/applications', [AdController::class, 'applications'])->name('ads.applications');
    Route::patch('/ads/{ad}/applications/{application}', [AdController::class, 'updateApplication'])->name('ads.applications.update');
});

// Ver perfil público de un músico o banda
Route::get('/musicians/{username}', [ProfileController::class, 'show'])->name('profile.show');

//Mostrar anuncios
Route::get('ads', [AdController::class, 'index'])->name('ads.index');

Route::get('/musicos', [MusicianController::class, 'musicos'])->middleware('auth')->name('musicos');
Route::get('/bandas', [MusicianController::class, 'bandas'])->middleware('auth')->name('bandas');

require __DIR__.'/auth.php';