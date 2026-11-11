<?php

use App\Models\Etudiant;
use App\Models\Votes;
use App\Notifications\RappelVote;
use App\Notifications\ResultatsDisponibles;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
 * Notifications par e-mail liées au calendrier des scrutins :
 *  - rappel aux étudiants qui n'ont pas encore voté, le dernier jour du scrutin ;
 *  - annonce des résultats, le lendemain de la clôture.
 *
 * À planifier une fois par jour (voir le README) : php artisan schedule:run
 */
Artisan::command('ugbvote:notifier', function () {
    $rappels = 0;
    $annonces = 0;

    foreach (Votes::with('ufrs')->get() as $scrutin) {
        $ufrs = $scrutin->ufrs->pluck('id_ufr');

        if ($scrutin->date_fin->isToday()) {
            $dejaVote = $scrutin->emargements()->select('etudiant_id');
            Etudiant::whereIn('ufr_id', $ufrs)->whereNotIn('id_etudiant', $dejaVote)
                ->each(function (Etudiant $etudiant) use ($scrutin, &$rappels) {
                    $etudiant->notify(new RappelVote($scrutin));
                    $rappels++;
                });
        }

        if ($scrutin->date_fin->isYesterday()) {
            Etudiant::whereIn('ufr_id', $ufrs)->each(function (Etudiant $etudiant) use (&$annonces) {
                $etudiant->notify(new ResultatsDisponibles);
                $annonces++;
            });
        }
    }

    $this->info("$rappels rappel(s) de vote et $annonces annonce(s) de résultats envoyés.");
})->purpose('Envoie les rappels de vote et les annonces de résultats du jour');

Schedule::command('ugbvote:notifier')->dailyAt('08:00');
