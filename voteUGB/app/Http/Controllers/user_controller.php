<?php

namespace App\Http\Controllers;

use App\Models\Bulletin;
use App\Models\Emargement;
use App\Models\Etudiant;
use App\Models\Listes;
use App\Models\Proposition;
use App\Notifications\VoteEnregistre;
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
            'emargement' => $etudiant->emargementPour($scrutin),
            'listes' => Listes::where('ufr_id', $etudiant->ufr_id)
                ->with(['membres' => fn ($q) => $q->where('tete_liste', true)->with('etudiant')])
                ->withCount('membres')
                ->orderBy('name_list')
                ->get(),
        ]);
    }

    /** Page de campagne d'une liste. */
    public function detailListe($id)
    {
        $etudiant = Auth::user();
        $liste = $this->listeDeMonUfr($id, $etudiant);
        $scrutin = $etudiant->ufr?->scrutin;
        $jeDirige = $etudiant->listeDirigee()?->id_list === $liste->id_list;

        return view('user.detailListe', [
            'liste' => $liste,
            'membres' => $liste->membres()->with('etudiant')->orderByDesc('tete_liste')->get(),
            'propositions' => $liste->propositions()->orderBy('id')->get()->groupBy('theme'),
            'realisations' => $liste->realisations,
            'themes' => Proposition::THEMES,
            // Tant que l'administration n'a pas validé les modifications, seul le candidat les voit.
            'campagneVisible' => $liste->campagne_validee || $jeDirige,
            'jeDirige' => $jeDirige,
            'scrutin' => $scrutin,
            'emargement' => $etudiant->emargementPour($scrutin),
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
            'emargement' => $etudiant->emargementPour($scrutin),
        ]);
    }

    /**
     * Dépôt du bulletin.
     *
     * Toutes les règles sont vérifiées côté serveur :
     *  - la liste doit appartenir à l'UFR de l'étudiant ;
     *  - le scrutin est celui de son UFR et doit être ouvert ;
     *  - un seul émargement par étudiant et par scrutin (contrainte d'unicité en base).
     *
     * Dans la même transaction, on enregistre l'émargement (nominatif, sans le choix)
     * et le bulletin (le choix, anonyme). Rien ne permet ensuite de les relier.
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

        $recu = Bulletin::nouveauRecu();

        try {
            DB::transaction(function () use ($etudiant, $scrutin, $liste, $recu) {
                Emargement::create([
                    'etudiant_id' => $etudiant->id_etudiant,
                    'vote_id' => $scrutin->id_vote,
                    'voted_at' => now(),
                ]);

                Bulletin::create([
                    'vote_id' => $scrutin->id_vote,
                    'list_id' => $liste->id_list,
                    'recu_hash' => Bulletin::empreinte($recu),
                ]);
            });
        } catch (UniqueConstraintViolationException) {
            return redirect()->route('election')
                ->with('error', 'Vous avez déjà voté pour ce scrutin : un seul vote par étudiant.');
        }

        // L'e-mail de confirmation ne doit jamais empêcher un vote d'aboutir.
        try {
            $etudiant->notify(new VoteEnregistre);
        } catch (\Throwable $e) {
            report($e);
        }

        // Le reçu n'est affiché qu'une fois : seule son empreinte est conservée.
        return redirect()->route('election')->with('vote_ok', true)->with('recu', $recu);
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

    public function formulaireRecu()
    {
        return view('user.recu', ['verdict' => null]);
    }

    /**
     * Vérifie qu'un reçu correspond à un bulletin présent dans l'urne.
     * La liste choisie n'est jamais révélée : un reçu ne peut pas servir de preuve de vote à un tiers.
     */
    public function verifierRecu(Request $request)
    {
        $donnees = $request->validate(['recu' => 'required|string|max:40']);

        $bulletin = Bulletin::where('recu_hash', Bulletin::empreinte($donnees['recu']))->first();

        return view('user.recu', [
            'verdict' => $bulletin ? 'present' : 'absent',
            'saisi' => $donnees['recu'],
        ]);
    }

    /** Une liste n'est visible que par les étudiants de son UFR. */
    private function listeDeMonUfr($id, Etudiant $etudiant): Listes
    {
        return Listes::where('id_list', $id)
            ->where('ufr_id', $etudiant->ufr_id)
            ->firstOrFail();
    }
}
