<?php

namespace App\Http\Controllers;

use App\Models\Listes;
use App\Models\MembresListe;
use App\Models\VoteEtudiant;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View as ViewFacade;





class user_controller extends Controller
{

    //fonction detailListe
    public function detailListe($id_list)
    {


        $membres = MembresListe::with('etudiant')->where('list_id', $id_list)->get();


        // Récupérer la liste par son ID
        $liste = Listes::find($id_list);

        if (!$liste) {
            return redirect()->back()->with('error', 'Liste introuvable');
        }

        // Retourner la vue avec les données de la liste
        return view('user.detailListe', compact('liste', 'membres'));
    }

    //fonction election
    public function election(Request $request)
    { 


        // Vérification et tentative d'authentification
        if (1) {
            // $request->session()->regenerate();

            $user = Auth::user();
            // $request->session()->put('ufr_id', $user->ufr_id);

            // Par exemple, récupérer les listes de vote pour cet UFR
            $listes = Listes::where('ufr_id',  $user->ufr_id)->get();

            if ($listes->isEmpty()) { #
                return view('user.election')->with('message', 'Aucune liste disponible pour votre UFR pour l\'instant.');
            }

            return view('user.election', ['listes' => $listes, 'etudiant' => $user])->with('success', 'Connexion réussie');
        }
    }

    //fonction page_vote
    public function page_vote(): View
    {
        return view('user.systemevote');
    }

    //fonction resultat
    public function resultat(): View
    {
        return view('user.resultat');
    }


    public function storeVote($id_list, Request $request)
    {

        $voteId = $request->input('vote_id');

        
        if (!$voteId) {
            return redirect()->back()->with('error','Erreur : Aucun vote en cours trouve');
        }

        $etudiantId = Auth::user()->id_etudiant;

        // Vérifier si l'étudiant a déjà voté pour ce vote
        $existingVote = VoteEtudiant::where('etudiant_id', $etudiantId)
            ->where('vote_id', $voteId)
            ->where('list_id', $id_list)
            ->first();

        if ($existingVote) {
            return redirect()->back()->with('error', 'Vous avez déjà voté pour ce vote en cours.');
        }

        // Créer l'enregistrement du vote
        VoteEtudiant::create([
            'etudiant_id' => $etudiantId,
            'vote_id'     => $voteId,
            'list_id'     => $id_list,  // Ajoutez l'ID de la liste si nécessaire
            'voted_at'    => now(),
            // Ajoutez d'autres champs si nécessaire, par exemple 'choix'
        ]);

        return redirect()->back()->with('success', 'Votre vote a bien été enregistré.');
    }


    //fonction showSystemeVote
    public function showSystemeVote($id)
    {
        // Récupérer la liste correspondant à l'ID passé dans l'URL
        $liste = Listes::find($id);
        if (!$liste) {
            return redirect()->back()->with('error', 'Liste introuvable');
        }
        // Vous pouvez également récupérer d'autres données nécessaires ici

        return view('user.systemevote', compact('liste'));
    }
}
