<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Anti force brute : 5 tentatives par minute et par couple e-mail / IP.
        RateLimiter::for('connexion', function (Request $request) {
            $cle = mb_strtolower((string) $request->input('email')).'|'.$request->ip();

            return Limit::perMinute(5)->by($cle);
        });

        // Limite la création de comptes en rafale depuis une même adresse.
        RateLimiter::for('inscription', fn (Request $request) => Limit::perMinute(6)->by($request->ip()));

        // Un bulletin se dépose une fois : inutile d'accepter des rafales.
        RateLimiter::for('vote', fn (Request $request) => Limit::perMinute(10)->by(
            optional($request->user())->getAuthIdentifier() ?: $request->ip()
        ));
    }
}
