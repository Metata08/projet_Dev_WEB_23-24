<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtudiantController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/inscription', function () {
    return view('inscription');
});

Route::post('/ajouterEtudiants', [EtudiantController::class, 'ajouterEtudiants'])->name('ajouterEtudiants');