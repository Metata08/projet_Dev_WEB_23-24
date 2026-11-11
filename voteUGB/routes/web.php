<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminGestionController;
use App\Http\Controllers\CampagneController;
use App\Http\Controllers\MotDePasseController;
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

    Route::get('/mot-de-passe-oublie', [MotDePasseController::class, 'demande'])->name('password.request');
    Route::post('/mot-de-passe-oublie', [MotDePasseController::class, 'envoyerLien'])->middleware('throttle:inscription')->name('password.email');
    Route::get('/reinitialiser/{token}', [MotDePasseController::class, 'formulaire'])->name('password.reset');
    Route::post('/reinitialiser', [MotDePasseController::class, 'reinitialiser'])->middleware('throttle:inscription')->name('password.update');
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

    // Reçu de vote : vérifier que son bulletin est bien dans l'urne.
    Route::get('/recu', [user_controller::class, 'formulaireRecu'])->name('recu');
    Route::post('/recu', [user_controller::class, 'verifierRecu'])->middleware('throttle:vote')->name('recu.verifier');

    // Campagne : comparateur et espace candidat (tête de liste).
    Route::get('/comparer', [CampagneController::class, 'comparer'])->name('comparer');
    Route::get('/ma-liste', [CampagneController::class, 'maListe'])->name('maListe');
    Route::put('/ma-liste', [CampagneController::class, 'majInfos'])->name('maListe.infos');
    Route::post('/ma-liste/propositions', [CampagneController::class, 'ajouterProposition'])->name('maListe.proposition');
    Route::delete('/ma-liste/propositions/{id}', [CampagneController::class, 'supprimerProposition'])->whereNumber('id')->name('maListe.proposition.supprimer');
    Route::post('/ma-liste/realisations', [CampagneController::class, 'ajouterRealisation'])->name('maListe.realisation');
    Route::delete('/ma-liste/realisations/{id}', [CampagneController::class, 'supprimerRealisation'])->whereNumber('id')->name('maListe.realisation.supprimer');
});

// Logo d'une liste : étudiants de l'UFR ou administrateur (contrôle dans le contrôleur).
Route::get('/listes/{id}/logo', [CampagneController::class, 'logo'])->whereNumber('id')->middleware('auth:web,admin')->name('liste.logo');

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
    Route::get('/scrutins/{id}/proces-verbal', [AdminGestionController::class, 'procesVerbal'])->whereNumber('id')->name('admin.pv');

    Route::get('/listes/{id}', [AdminGestionController::class, 'liste'])->whereNumber('id')->name('admin.liste');
    Route::post('/listes/{id}/valider', [AdminGestionController::class, 'validerCampagne'])->whereNumber('id')->name('admin.liste.valider');
    Route::post('/listes/{id}/membres', [AdminGestionController::class, 'ajouterMembre'])->whereNumber('id')->name('admin.liste.membre');
    Route::delete('/listes/{id}/membres/{membre}', [AdminGestionController::class, 'retirerMembre'])->whereNumber(['id', 'membre'])->name('admin.liste.membre.retirer');

    Route::get('/codes', [AdminGestionController::class, 'codes'])->name('admin.codes');
    Route::post('/codes', [AdminGestionController::class, 'importerCodes'])->name('admin.codes.importer');
    Route::delete('/codes/{id}', [AdminGestionController::class, 'supprimerCode'])->whereNumber('id')->name('admin.codes.supprimer');

    Route::get('/journal', [AdminGestionController::class, 'journal'])->name('admin.journal');
});
