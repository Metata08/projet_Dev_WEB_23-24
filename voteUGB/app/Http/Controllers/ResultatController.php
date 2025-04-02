<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listes;
use App\Models\VoteEtudiant;

class ResultatController extends Controller
{
    public function getResultats()
{
    // Nombre total de votes pour ce scrutin
    $totalVotes = VoteEtudiant::count();

    // recuperation des  résultats par liste avec le nombre de votes
    $resultats = Listes::withCount('voteEtudiants')->get()->map(function ($liste) use ($totalVotes) {
        return [
            'id' => $liste->id_list,  // Identifiant de la liste
            'liste' => $liste->name_list, 
            'votes' => $liste->vote_etudiants_count, // Nombre de votes obtenus
            'pourcentage' => $totalVotes > 0 ? round(($liste->vote_etudiants_count / $totalVotes) * 100, 2) : 0, // Calcul du pourcentage de votes 
        ];
    });

    return response()->json([
        'total_votes' => $totalVotes,
        'resultats' => $resultats
    ]);
}

}
