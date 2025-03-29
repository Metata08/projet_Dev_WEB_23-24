<?php

use App\Http\Controllers\login_controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user_controller;
// use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    // return view('welcome');
    // return view('user.systemevote');
    // return view('user.detailListe');
    // return view('user.login');
});


Route::get('/', function () {
    return view('welcome');
});

// Définir la route pour la page systemVOte 
Route::get('/systemevote', [user_controller::class, 'page_vote'])->name('systemevote');

// Définir la route pour la page login
Route::get('/login', [login_controller::class, 'showLoginForm'])->name('login');

// Définir la route pour la page inscription
Route ::get ('/inscription', [login_controller::class, 'inscription'])->name('inscription');

// Définir la route pour la page election

Route::get('/election', [login_controller::class, 'connecter'])->name('election');

// Définir la route pour la page détailListe
Route::get('/detailListe', [user_controller::class, 'detailListe'])->name('detailListe');











