<?php

use App\Http\Controllers\inscription_controller;
use App\Http\Controllers\login_controller;
use App\Http\Controllers\ResultatController;
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

Route::get('/login', [login_controller::class, 'showLoginForm'])->name('login');

Route ::get ('/inscription', [login_controller::class, 'inscription'])->name('inscription');

Route::get('/election', [user_controller::class, 'election'])->name('election');

Route::get('/detailListe/{id}', [user_controller::class, 'detailListe'])->name('detailListe');



// Définir la route pour la page resultat
Route::get('/resultat', [user_controller::class, 'resultat'])->name('resultat');


// pour la connexion pour les user

Route::post('/login', [login_controller::class, 'login'])->name('login.post');
Route::post('/logout', [login_controller::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/election', function () {
        return view('user.election'); 
    })->name('election');
});


Route::post('/inscription', [inscription_controller::class, 'register'])->name('inscription.register');

// Définir la route pour la page systemVote 
Route::get('/systemevote/{id}', [user_controller::class, 'showSystemeVote'])->name('systemevote');
Route::post('/systemevote/{id}', [user_controller::class, 'storeVote'])->name('systemevote.vote');

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



use Illuminate\Support\Facades\DB;

Route::get('/resultats/json', function () {
    $positions = DB::table('vote_etudiants')
        ->join('listes', 'vote_etudiants.list_id', '=', 'listes.id_list')
        ->join('u_f_r_s', 'u_f_r_s.id_ufr', '=', 'listes.ufr_id')
        ->select('u_f_r_s.nom as position', 'listes.name_list as candidat', DB::raw('COUNT(vote_etudiants.id) as nombre_de_votes'))
        ->groupBy('u_f_r_s.nom', 'listes.id_list')
        ->orderBy('u_f_r_s.nom')
        ->orderByDesc('nombre_de_votes')
        ->get();

    return @json_encode($positions);
})->name('resultats.json');


