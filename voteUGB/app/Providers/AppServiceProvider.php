<?php

namespace App\Providers;

use App\Http\Controllers\login_controller;
use App\Models\Listes;
use App\Models\UFR;
use App\Models\Votes;
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
        // On peut continuer à utiliser votre composer existant, par exemple :
        FacadesView::composer('*', login_controller::class);

        // Partager automatiquement 'etudiant', 'listes' et la date de fin de vote (dateFinVote)

        // Vous pouvez conserver d'autres view composers si nécessaire...
        FacadesView::composer('*', function (\Illuminate\View\View $view) {
            if (Auth::check()) {
                $etudiant = Auth::user();
                // Récupérer les listes associées à l'UFR de l'étudiant
                $listes = Listes::where('ufr_id', $etudiant->ufr_id)->get();

                // Récupérer l'UFR via son id
                $ufr = UFR::find($etudiant->ufr_id);
                $dateFinVote = null;
                $vote_id = $ufr->vote_id;
                if ($ufr && $ufr->vote_id) {
                    // Récupérer le vote lié à l'UFR
                    $vote = Votes::find($ufr->vote_id);
                    if ($vote) {
                        $dateFinVote = $vote->date_fin;
                        // $vote_id = $vote->id_vote; //j'ai ajouter cette ligne a l'instant
                    }
                }

                $view->with('etudiant', $etudiant)
                    ->with('listes', $listes)
                    ->with('dateFinVote', $dateFinVote)
                    ->with('voteId', $vote_id); //j'ai ajouter cette ligne a l'instant
            } else {
                $view->with('etudiant', null)
                    ->with('listes', collect([]))
                    ->with('dateFinVote', null)
                    ->with('voteId', null);//j'ai ajouter cette ligne a l'instant
            }
        });
    }
}
