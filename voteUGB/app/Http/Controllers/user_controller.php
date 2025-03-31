<?php

namespace App\Http\Controllers;

use App\Models\Listes;
use App\Models\MembresListe;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class user_controller extends Controller
{

    //fonction detailListe
    public function detailListe($id_list)
    {
        // $liste = Listes::find($id_list);
        // $membres = $liste->membres;

        $membres = MembresListe::with('etudiant')->where('list_id', $id_list)->get();


        // Récupérer la liste par son ID
        $liste = Listes::find($id_list);

        if (!$liste) {
            return redirect()->back()->with('error', 'Liste introuvable');
        }

        // Retourner la vue avec les données de la liste
        return view('user.detailListe', compact('liste','membres'));
    }

    //fonction election
    public function election($id_ufr, Request $request)
    {
        // Validation des champs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Vérification et tentative d'authentification
        if (Auth::attempt(['mail' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            $user = Auth::user();
            $request->session()->put('ufr_id', $user->ufr_id);

            // Par exemple, récupérer les listes de vote pour cet UFR
            $listes = Listes::where('ufr_id',  $user->ufr_id)->get();

            if ($listes->isEmpty()) { #
                return view('user.election')->with('message', 'Aucune liste disponible pour votre UFR pour l\'instant.');
            }

            return view('user.election', ['listes' => $listes, 'etudiant' => $user])->with('success', 'Connexion réussie');
            // return redirect()->route('election', ['ufr_id' => $user->ufr_id])->with('success', 'Connexion réussie');
        }



        /* // Récupérer les listes dont l'ufr_id correspond à l'ID de l'UFR de l'utilisateur
        dd($id_ufr);
        $listes = Listes::where('ufr_id', null, $id_ufr)->get();


        if ($listes->isEmpty()) {
            return view('user.election')->with('message', 'Aucune liste disponible pour votre UFR pour l\'instant.');
        }
        // return view('user.election', ['listes' => $listes,'etudiant'=> $user])->with('success', 'Connexion réussie');

        // Retourner la vue avec les listes
        return view('user.election', compact('listes'))->with('success', 'Connexion réussie'); */
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
}
