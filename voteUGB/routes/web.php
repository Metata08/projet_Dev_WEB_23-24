<?php

use App\Http\Controllers\login_controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user_controller;
// use App\Http\Controllers\Auth\login_controller;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('ugbvote');
});


// Définir la route pour la page de  ugbvote
Route::get('/ugbvote', [login_controller::class, 'accueil' ])->name('ugbvote');


// Définir la route pour la page systemVOte 
Route::get('/systemevote', [user_controller::class, 'page_vote'])->name('systemevote');

// Définir la route pour la page login
Route::get('/login', [login_controller::class, 'showLoginForm'])->name('login');

// Définir la route pour la page inscription
Route ::get ('/inscription', [login_controller::class, 'inscription'])->name('inscription');

// Définir la route pour la page election

// Route::get('/election', [login_controller::class, 'connecter'])->name('election');
Route::get('/election/{id_ufr}', [user_controller::class, 'election'])->name('election');

// Définir la route pour la page détailListe
Route::get('/detailListe/{id}', [user_controller::class, 'detailListe'])->name('detailListe');



// Définir la route pour la page resultat
Route::get('/resultat', [user_controller::class, 'resultat'])->name('resultat');


// pour la connexion pour les user

Route::get('/login', [login_controller::class, 'showLoginForm'])->name('login');
Route::post('/login', [login_controller::class, 'login'])->name('login.post');
Route::post('/logout', [login_controller::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/election', function () {
        return view('user.election'); 
    })->name('election');
});

// Afficher la page de connexion
Route::get('/admin', [AdminController::class, 'index'])->name('admin');

// Vérifier l'authentification
Route::post('/admin/login', [AdminController::class, 'loginAdmin'])->name('admin.login');

Route::get('/dashboardAdmin', [AdminController::class, 'dashboardAdmin'])->name('dashboardAdmin');
Route::post('/logoutAdmin', [AdminController::class, 'logoutAdmin'])->name('logoutAdmin');
Route::get('/listeCandidats', [AdminController::class, 'listeCandidats'])->name('listeCandidats');
Route::get('/listePostes', [AdminController::class, 'listePostes'])->name('listePostes');
Route::get('/afficherEtudiant', [AdminController::class, 'afficherEtudiant'])->name('afficherEtudiant');
Route::get('/listeElecteurs', [AdminController::class, 'listeElecteurs'])->name('listeElecteurs');

Route::delete('/deleteElecteur/{id}', [AdminController::class, 'deleteElecteur'])->name('deleteElecteur');
Route::post('/enregistrer-list', [AdminController::class, 'enregistrerList'])->name('enregistrerList');


Route::post('/ajouterEtudiants', [EtudiantController::class, 'ajouterEtudiants'])->name('ajouterEtudiants');