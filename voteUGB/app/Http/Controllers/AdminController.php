<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Listes;
use App\Models\UFR;
use App\Models\Emargement;
use App\Models\Votes;
use App\Support\Depouillement;
use App\Support\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function loginAdmin(Request $request)
    {
        $identifiants = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
        ]);

        $identifiants['email'] = mb_strtolower(trim($identifiants['email']));

        // Le mot de passe est comparé à son empreinte bcrypt, jamais en clair.
        if (! Auth::guard('admin')->attempt($identifiants)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Identifiants incorrects.']);
        }

        $request->session()->regenerate();
        Journal::note('Connexion');

        return redirect()->intended(route('dashboardAdmin'));
    }

    public function logoutAdmin(Request $request)
    {
        Journal::note('Déconnexion');
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin')->with('success', 'Session administrateur fermée.');
    }

    public function dashboardAdmin()
    {
        return view('admin.home', ['stats' => $this->statistiques()]);
    }

    /** Flux JSON du tableau de bord (rafraîchissement automatique). */
    public function statsJson()
    {
        return response()->json($this->statistiques())->header('Cache-Control', 'no-store');
    }

    public function listeElecteurs()
    {
        return view('admin.electeurs', [
            'etudiants' => Etudiant::with('ufr')->withCount('emargements')->orderBy('nom')->orderBy('prenom')->get(),
        ]);
    }

    public function deleteElecteur($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->delete();
        Journal::note('Électeur supprimé', $etudiant->nom_complet.' ('.$etudiant->code_etudiant.')');

        return redirect()->route('listeElecteurs')->with('success', 'Électeur supprimé.');
    }

    public function listeCandidats()
    {
        return view('admin.candidates', [
            'listesC' => Listes::with('ufr')->withCount(['membres', 'bulletins'])->orderBy('ufr_id')->orderBy('name_list')->get(),
            'ufrs' => UFR::orderBy('nom')->get(),
        ]);
    }

    public function enregistrerList(Request $request)
    {
        $donnees = $request->validate([
            'nom' => 'required|string|max:120',
            'programme' => 'required|string|max:10000',
            'ufr' => ['required', Rule::exists('u_f_r_s', 'id_ufr')],
        ], [], ['nom' => 'nom de la liste', 'ufr' => 'UFR']);

        Listes::create([
            'name_list' => $donnees['nom'],
            'programme' => $donnees['programme'],
            'ufr_id' => $donnees['ufr'],
        ]);

        Journal::note('Liste ajoutée', $donnees['nom']);

        return redirect()->route('listeCandidats')->with('success', 'Liste « '.$donnees['nom'].' » ajoutée.');
    }

    public function deleteListe($id)
    {
        $liste = Listes::findOrFail($id);
        $liste->delete();
        Journal::note('Liste supprimée', $liste->name_list);

        return redirect()->route('listeCandidats')->with('success', 'Liste supprimée.');
    }

    /** Scrutins : période de vote de chaque UFR. */
    public function listePostes()
    {
        return view('admin.postes', [
            'ufrs' => UFR::with('scrutin')->withCount(['etudiants', 'listes'])->orderBy('nom')->get(),
        ]);
    }

    public function majScrutin(Request $request, $id)
    {
        $ufr = UFR::findOrFail($id);

        $donnees = $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'resultats_en_direct' => 'nullable|boolean',
        ], [], ['date_debut' => "date d'ouverture", 'date_fin' => 'date de clôture']);

        $donnees['resultats_en_direct'] = $request->boolean('resultats_en_direct');

        if ($ufr->scrutin) {
            $ufr->scrutin->update($donnees);
        } else {
            $ufr->update(['vote_id' => Votes::create($donnees)->id_vote]);
        }

        Journal::note('Scrutin modifié', 'UFR '.$ufr->sigle.' : du '.$donnees['date_debut'].' au '.$donnees['date_fin'].($donnees['resultats_en_direct'] ? ', résultats en direct' : ', résultats à la clôture'));

        return redirect()->route('listePostes')->with('success', 'Scrutin de l\'UFR '.$ufr->sigle.' mis à jour.');
    }

    private function statistiques(): array
    {
        $inscrits = Etudiant::count();
        $votants = Emargement::distinct()->count('etudiant_id');

        return [
            'ufr' => UFR::count(),
            'listes' => Listes::count(),
            'inscrits' => $inscrits,
            'votants' => $votants,
            'participation' => $inscrits > 0 ? round($votants / $inscrits * 100, 1) : 0,
            'maj' => now()->format('H:i:s'),
            // Les UFR les plus actives d'abord.
            'parUfr' => UFR::with('scrutin')->orderBy('nom')->get()
                ->map(fn (UFR $ufr) => Depouillement::pour($ufr, toutVoir: true))
                ->sortByDesc(fn (array $bloc) => [count($bloc['resultats']) > 0, $bloc['total_votes']])
                ->values()->all(),
        ];
    }
}
