<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\login_controller;
use App\Http\Controllers\user_controller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\PositionController;
use App\Http\Controllers\admin\CandidateController;
use App\Http\Controllers\admin\VoterController;
use App\Http\Controllers\admin\VoteController;
use App\Http\Controllers\admin\ReportController;

// Page d'accueil publique
Route::get('/', function () {
    return view('welcome');
});

// Routes publiques
Route::get('/systemevote', [user_controller::class, 'page_vote'])->name('systemevote');
Route::get('/login', [login_controller::class, 'showLoginForm'])->name('login');
Route::get('/inscription', [login_controller::class, 'inscription'])->name('inscription');
Route::get('/election', [login_controller::class, 'connecter'])->name('election');
Route::get('/detailListe', [user_controller::class, 'detailListe'])->name('detailListe');

// Routes admin (non protégées)
Route::get('/loginAdmin', [AdminController::class, 'loginAdmin'])->name('loginAdmin');
Route::get('/logoutAdmin', [AdminController::class, 'logoutAdmin'])->name('logoutAdmin');

// Routes admin protégées
Route::prefix('admin')->name('admin.')->group(function() {
    Route::middleware('auth')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboardAdmin', [AdminController::class, 'dashboard'])->name('dashboardAdmin');
        
        // Vérification manuelle du rôle admin
        Route::group(['middleware' => function ($request, $next) {
            if (!auth()->user()->is_admin) {
                return redirect()->route('loginAdmin')->with('error', 'Accès non autorisé');
            }
            return $next($request);
        }], function() {
            Route::resource('positions', PositionController::class);
            Route::resource('candidates', CandidateController::class);
            Route::resource('voters', VoterController::class);
            Route::resource('votes', VoteController::class);
            Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');
        });
    });
});