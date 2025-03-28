<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoteController;

// Routes publiques
// Supprime la route "view" pour /login
// Route::view('/login', 'login')->name('login'); // Supprimer cette ligne

Route::view('/register', 'register')->name('register');
Route::view('/password/reset', 'passwords.email')->name('password.request');

// Rendre /vote accessible sans authentification
Route::get('/vote', [VoteController::class, 'index'])->name('vote.index');

// Routes pour la connexion
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); // Méthode GET pour afficher le formulaire
Route::post('/login', [LoginController::class, 'login']); // Méthode POST pour soumettre les informations

// Routes protégées par auth
Route::middleware('auth')->group(function () {
    Route::get('/votes', [VoteController::class, 'index'])->name('votes.index');
    Route::get('/vote/{id}', [VoteController::class, 'vote'])->name('vote.show');
    Route::post('/vote/{id}', [VoteController::class, 'storeVote'])->name('vote.store');
});
