<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\inscription_controller;
use App\Http\Controllers\login_controller;
use App\Http\Controllers\user_controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Pages publiques
|--------------------------------------------------------------------------
*/
Route::get('/', [login_controller::class, 'accueil']);
Route::get('/ugbvote', [login_controller::class, 'accueil'])->name('ugbvote');

/*
|--------------------------------------------------------------------------
| Authentification des étudiants
|--------------------------------------------------------------------------
*/
Route::middleware('guest:web')->group(function () {
    Route::get('/login', [login_controller::class, 'showLoginForm'])->name('login');
    Route::post('/login', [login_controller::class, 'login'])->middleware('throttle:connexion')->name('login.post');
    Route::get('/inscription', [login_controller::class, 'inscription'])->name('inscription');
    Route::post('/inscription', [inscription_controller::class, 'register'])->middleware('throttle:inscription')->name('inscription.register');
});

/*
|--------------------------------------------------------------------------
| Espace étudiant (authentification obligatoire)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:web')->group(function () {
    Route::post('/logout', [login_controller::class, 'logout'])->name('logout');

    Route::get('/election', [user_controller::class, 'election'])->name('election');
    Route::get('/detailListe/{id}', [user_controller::class, 'detailListe'])->whereNumber('id')->name('detailListe');
    Route::get('/systemevote/{id}', [user_controller::class, 'showSystemeVote'])->whereNumber('id')->name('systemevote');
    Route::post('/systemevote/{id}', [user_controller::class, 'storeVote'])->whereNumber('id')->middleware('throttle:vote')->name('systemevote.vote');

    Route::get('/resultat', [user_controller::class, 'resultat'])->name('resultat');
    Route::get('/resultats/json', [user_controller::class, 'resultatsJson'])->name('resultats.json');
});

/*
|--------------------------------------------------------------------------
| Espace administrateur (garde « admin »)
|--------------------------------------------------------------------------
*/
Route::middleware('guest:admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::post('/admin/login', [AdminController::class, 'loginAdmin'])->middleware('throttle:connexion')->name('admin.login');
});

Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::post('/logout', [AdminController::class, 'logoutAdmin'])->name('logoutAdmin');

    Route::get('/tableau-de-bord', [AdminController::class, 'dashboardAdmin'])->name('dashboardAdmin');
    Route::get('/stats.json', [AdminController::class, 'statsJson'])->name('admin.stats');

    Route::get('/electeurs', [AdminController::class, 'listeElecteurs'])->name('listeElecteurs');
    Route::delete('/electeurs/{id}', [AdminController::class, 'deleteElecteur'])->whereNumber('id')->name('deleteElecteur');

    Route::get('/listes', [AdminController::class, 'listeCandidats'])->name('listeCandidats');
    Route::post('/listes', [AdminController::class, 'enregistrerList'])->name('enregistrerList');
    Route::delete('/listes/{id}', [AdminController::class, 'deleteListe'])->whereNumber('id')->name('deleteListe');

    Route::get('/scrutins', [AdminController::class, 'listePostes'])->name('listePostes');
    Route::put('/scrutins/{id}', [AdminController::class, 'majScrutin'])->whereNumber('id')->name('majScrutin');
});
