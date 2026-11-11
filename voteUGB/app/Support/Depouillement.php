<?php

namespace App\Support;

use App\Models\UFR;

/**
 * Calcule les résultats d'une UFR pour son scrutin courant.
 */
class Depouillement
{
    public static function pour(UFR $ufr): array
    {
        $scrutin = $ufr->scrutin;
        $idScrutin = $scrutin?->id_vote;

        $listes = $ufr->listes()
            ->withCount(['voteEtudiants as voix' => fn ($q) => $q->where('vote_id', $idScrutin)])
            ->orderByDesc('voix')
            ->orderBy('name_list')
            ->get();

        $exprimes = (int) $listes->sum('voix');
        $inscrits = $ufr->etudiants()->count();
        $voixMax = (int) $listes->max('voix');

        return [
            'ufr' => $ufr->sigle,
            'statut' => $scrutin?->statut,
            'inscrits' => $inscrits,
            'total_votes' => $exprimes,
            'participation' => $inscrits > 0 ? round($exprimes / $inscrits * 100, 1) : 0,
            'maj' => now()->format('H:i:s'),
            'resultats' => $listes->map(fn ($liste) => [
                'id' => $liste->id_list,
                'liste' => $liste->name_list,
                'votes' => (int) $liste->voix,
                'pourcentage' => $exprimes > 0 ? round($liste->voix / $exprimes * 100, 1) : 0,
                'en_tete' => $exprimes > 0 && (int) $liste->voix === $voixMax,
            ])->values()->all(),
        ];
    }
}
