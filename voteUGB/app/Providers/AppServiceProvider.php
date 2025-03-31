<?php

namespace App\Providers;

use App\Http\Controllers\login_controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View as FacadesView;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         // Partager la variable 'etudiant' dans toutes les vues
    // Appliquer le composer à toutes les vues ou à certaines vues (ici, toutes)
    FacadesView::composer('*', login_controller::class);
    }
}
