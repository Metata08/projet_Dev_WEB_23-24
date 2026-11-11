<?php

namespace App\Support;

use App\Models\Emargement;
use App\Models\UFR;

/**
 * Calcule les résultats d'une UFR pour son scrutin courant.
 *
 * La participation vient des émargements (qui a voté) ; le décompte par liste
 * vient des bulletins anonymes (pour qui). Les deux ne sont jamais croisés.
 */
class Depouillement
{
    /**
     * @param  bool  $toutVoir  true pour l'administration : ignore le masquage des résultats avant clôture.
     */
    public static function pour(UFR $ufr, bool $toutVoir = false): array
    {
        $scrutin = $ufr->scrutin;
        $idScrutin = $scrutin?->id_vote;

        $inscrits = $ufr->etudiants()->count();
        $votants = $idScrutin
            ? Emargement::where('vote_id', $idScrutin)
                ->whereIn('etudiant_id', $ufr->etudiants()->select('id_etudiant'))
                ->count()
            : 0;

        $visible = $toutVoir || ! $scrutin || $scrutin->resultatsVisibles();
        $resultats = [];
        $exprimes = 0;

        if ($visible) {
            $listes = $ufr->listes()
                ->withCount(['bulletins as voix' => fn ($q) => $q->where('vote_id', $idScrutin)])
                ->orderByDesc('voix')
                ->orderBy('name_list')
                ->get();

            $exprimes = (int) $listes->sum('voix');
            $voixMax = (int) $listes->max('voix');

            $resultats = $listes->map(fn ($liste) => [
                'id' => $liste->id_list,
                'liste' => $liste->name_list,
                'votes' => (int) $liste->voix,
                'pourcentage' => $exprimes > 0 ? round($liste->voix / $exprimes * 100, 1) : 0,
                'en_tete' => $exprimes > 0 && (int) $liste->voix === $voixMax,
            ])->values()->all();
        }

        return [
            'ufr' => $ufr->sigle,
            'statut' => $scrutin?->statut,
            'visible' => $visible,
            'inscrits' => $inscrits,
            'votants' => $votants,
            'total_votes' => $visible ? $exprimes : $votants,
            'participation' => $inscrits > 0 ? round($votants / $inscrits * 100, 1) : 0,
            'maj' => now()->format('H:i:s'),
            'resultats' => $resultats,
        ];
    }
}
