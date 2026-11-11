<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Listes;
use App\Models\VoteEtudiant;
use App\Support\Depouillement;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class user_controller extends Controller
{
    /** Listes candidates de l'UFR de l'étudiant connecté. */
    public function election()
    {
        $etudiant = Auth::user();
        $scrutin = $etudiant->ufr?->scrutin;

        return view('user.election', [
            'etudiant' => $etudiant,
            'scrutin' => $scrutin,
            'bulletin' => $etudiant->bulletinPour($scrutin),
            'listes' => Listes::where('ufr_id', $etudiant->ufr_id)
                ->with(['membres' => fn ($q) => $q->where('tete_liste', true)->with('etudiant')])
                ->withCount('membres')
                ->orderBy('name_list')
                ->get(),
        ]);
    }

    public function detailListe($id)
    {
        $etudiant = Auth::user();
        $liste = $this->listeDeMonUfr($id, $etudiant);
        $scrutin = $etudiant->ufr?->scrutin;

        return view('user.detailListe', [
            'liste' => $liste,
            'membres' => $liste->membres()->with('etudiant')->orderByDesc('tete_liste')->get(),
            'scrutin' => $scrutin,
            'bulletin' => $etudiant->bulletinPour($scrutin),
        ]);
    }

    /** Écran de confirmation avant dépôt du bulletin. */
    public function showSystemeVote($id)
    {
        $etudiant = Auth::user();
        $liste = $this->listeDeMonUfr($id, $etudiant);
        $scrutin = $etudiant->ufr?->scrutin;

        return view('user.systemevote', [
            'liste' => $liste,
            'teteDeListe' => $liste->membres()->where('tete_liste', true)->with('etudiant')->first()?->etudiant,
            'scrutin' => $scrutin,
            'bulletin' => $etudiant->bulletinPour($scrutin),
        ]);
    }

    /**
     * Dépôt du bulletin.
     *
     * Toutes les règles sont vérifiées côté serveur ; rien ne dépend de ce
     * qu'envoie le navigateur en dehors de l'identifiant de la liste choisie :
     *  - la liste doit appartenir à l'UFR de l'étudiant ;
     *  - le scrutin est celui de son UFR et doit être ouvert ;
     *  - un seul bulletin par étudiant et par scrutin (contrainte d'unicité en base).
     */
    public function storeVote($id, Request $request)
    {
        $request->validate(['confirmation' => 'accepted'], [
            'confirmation.accepted' => 'Veuillez confirmer votre choix avant de voter.',
        ]);

        $etudiant = Auth::user();
        $liste = $this->listeDeMonUfr($id, $etudiant);
        $scrutin = $etudiant->ufr?->scrutin;

        if (! $scrutin || ! $scrutin->estOuvert()) {
            return redirect()->route('election')
                ->with('error', "Le scrutin de votre UFR n'est pas ouvert : aucun vote ne peut être enregistré.");
        }

        try {
            DB::transaction(function () use ($etudiant, $scrutin, $liste) {
                VoteEtudiant::create([
                    'etudiant_id' => $etudiant->id_etudiant,
                    'vote_id' => $scrutin->id_vote,
                    'list_id' => $liste->id_list,
                    'voted_at' => now(),
                ]);
            });
        } catch (UniqueConstraintViolationException) {
            return redirect()->route('election')
                ->with('error', 'Vous avez déjà voté pour ce scrutin : un seul vote par étudiant.');
        }

        return redirect()->route('election')->with('vote_ok', true);
    }

    public function resultat()
    {
        $etudiant = Auth::user();

        return view('user.resultat', [
            'scrutin' => $etudiant->ufr?->scrutin,
            'donnees' => Depouillement::pour($etudiant->ufr),
        ]);
    }

    /** Flux JSON rafraîchi automatiquement par la page des résultats. */
    public function resultatsJson()
    {
        return response()->json(Depouillement::pour(Auth::user()->ufr))
            ->header('Cache-Control', 'no-store');
    }

    /** Une liste n'est visible que par les étudiants de son UFR. */
    private function listeDeMonUfr($id, Etudiant $etudiant): Listes
    {
        return Listes::where('id_list', $id)
            ->where('ufr_id', $etudiant->ufr_id)
            ->firstOrFail();
    }
}
