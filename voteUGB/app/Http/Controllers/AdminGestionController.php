<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\EtudiantOfficiel;
use App\Models\JournalAdmin;
use App\Models\Listes;
use App\Models\MembresListe;
use App\Models\Proposition;
use App\Models\UFR;
use App\Support\Depouillement;
use App\Support\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Administration : campagne d'une liste, codes étudiants officiels, procès-verbal, journal.
 */
class AdminGestionController extends Controller
{
    /* ---------- Campagne et membres d'une liste -------------------------- */

    public function liste($id)
    {
        $liste = Listes::with(['ufr', 'realisations'])->findOrFail($id);
        $membres = $liste->membres()->with('etudiant')->orderByDesc('tete_liste')->get();

        return view('admin.liste', [
            'liste' => $liste,
            'membres' => $membres,
            'propositions' => $liste->propositions()->orderBy('id')->get()->groupBy('theme'),
            'themes' => Proposition::THEMES,
            'candidats' => Etudiant::where('ufr_id', $liste->ufr_id)
                ->whereNotIn('id_etudiant', $membres->pluck('id_membre'))
                ->orderBy('nom')->orderBy('prenom')->get(),
        ]);
    }

    public function validerCampagne($id)
    {
        $liste = Listes::findOrFail($id);
        $liste->update(['campagne_validee' => true]);
        Journal::note('Campagne validée', $liste->name_list);

        return back()->with('success', 'Page de campagne publiée.');
    }

    public function ajouterMembre(Request $request, $id)
    {
        $liste = Listes::findOrFail($id);

        $donnees = $request->validate([
            // Un membre doit être un étudiant de la même UFR que la liste.
            'etudiant' => ['required', Rule::exists('etudiants', 'id_etudiant')->where('ufr_id', $liste->ufr_id)],
            'role' => 'nullable|string|max:80',
            'tete_liste' => 'nullable|boolean',
        ], ['etudiant.exists' => "Cet étudiant n'appartient pas à l'UFR de la liste."], ['role' => 'rôle']);

        if ($liste->membres()->where('id_membre', $donnees['etudiant'])->exists()) {
            return back()->with('error', 'Cet étudiant est déjà membre de la liste.');
        }

        DB::transaction(function () use ($liste, $donnees, $request) {
            $tete = $request->boolean('tete_liste');

            if ($tete) {
                // Une seule tête de liste à la fois.
                $liste->membres()->update(['tete_liste' => false]);
            }

            MembresListe::create([
                'list_id' => $liste->id_list,
                'id_membre' => $donnees['etudiant'],
                'role' => $donnees['role'] ?? null,
                'tete_liste' => $tete,
            ]);
        });

        Journal::note('Membre ajouté', $liste->name_list.' ← étudiant n° '.$donnees['etudiant']);

        return back()->with('success', 'Membre ajouté à la liste.');
    }

    public function retirerMembre($id, $membre)
    {
        $liste = Listes::findOrFail($id);
        $liste->membres()->where('id', $membre)->firstOrFail()->delete();
        Journal::note('Membre retiré', $liste->name_list);

        return back()->with('success', 'Membre retiré de la liste.');
    }

    /* ---------- Codes étudiants officiels -------------------------------- */

    public function codes()
    {
        $utilises = Etudiant::pluck('email', 'code_etudiant');

        return view('admin.codes', [
            'codes' => EtudiantOfficiel::orderBy('code')->get()
                ->map(fn ($c) => ['id' => $c->id, 'code' => $c->code, 'compte' => $utilises[$c->code] ?? null]),
        ]);
    }

    /** Ajout d'un code, ou import d'un fichier CSV / texte (un code par ligne ou par cellule). */
    public function importerCodes(Request $request)
    {
        $request->validate([
            'code' => 'nullable|required_without:fichier|string|max:50',
            'fichier' => 'nullable|required_without:code|file|mimes:csv,txt|max:1024',
        ], ['code.required_without' => 'Saisissez un code ou choisissez un fichier.']);

        $bruts = [];

        if ($request->filled('code')) {
            $bruts[] = $request->input('code');
        }

        if ($request->hasFile('fichier')) {
            $contenu = (string) file_get_contents($request->file('fichier')->getRealPath());
            $contenu = preg_replace('/^\xEF\xBB\xBF/', '', $contenu); // BOM éventuel d'Excel
            $bruts = array_merge($bruts, preg_split('/[\r\n;,\t]+/', $contenu));
        }

        // Format attendu : lettres, chiffres, espaces et tirets (ex. « p31 2127 »).
        $codes = collect($bruts)->map(fn ($c) => trim($c, " \t\"'"))
            ->filter(fn ($c) => $c !== '' && mb_strlen($c) <= 50 && preg_match('/^[\pL\d][\pL\d \-]*$/u', $c))
            ->reject(fn ($c) => in_array(mb_strtolower($c), ['code', 'codes', 'code etudiant', 'code étudiant'], true))
            ->unique()->take(5000)->values();

        if ($codes->isEmpty()) {
            return back()->with('error', 'Aucun code valide trouvé.');
        }

        $existants = EtudiantOfficiel::whereIn('code', $codes)->pluck('code');
        $nouveaux = $codes->diff($existants);

        foreach ($nouveaux->chunk(500) as $lot) {
            EtudiantOfficiel::insert($lot->map(fn ($c) => ['code' => $c, 'created_at' => now(), 'updated_at' => now()])->all());
        }

        Journal::note('Codes étudiants importés', $nouveaux->count().' ajouté(s), '.$existants->count().' déjà connu(s)');

        return back()->with('success', $nouveaux->count().' code(s) ajouté(s), '.$existants->count().' déjà présent(s).');
    }

    public function supprimerCode($id)
    {
        $code = EtudiantOfficiel::findOrFail($id);

        if (Etudiant::where('code_etudiant', $code->code)->exists()) {
            return back()->with('error', 'Ce code est utilisé par un compte : supprimez d\'abord l\'électeur.');
        }

        $code->delete();
        Journal::note('Code étudiant supprimé', $code->code);

        return back()->with('success', 'Code supprimé.');
    }

    /* ---------- Procès-verbal et journal --------------------------------- */

    public function procesVerbal($id)
    {
        $ufr = UFR::with('scrutin')->findOrFail($id);
        Journal::note('Procès-verbal consulté', 'UFR '.$ufr->sigle);

        return view('admin.pv', [
            'ufr' => $ufr,
            'scrutin' => $ufr->scrutin,
            'donnees' => Depouillement::pour($ufr, toutVoir: true),
        ]);
    }

    public function journal()
    {
        return view('admin.journal', ['entrees' => JournalAdmin::orderByDesc('id')->limit(300)->get()]);
    }
}
