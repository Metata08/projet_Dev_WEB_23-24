<?php

namespace App\Http\Controllers;

use App\Models\Listes;
use App\Models\Proposition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

/**
 * Campagne : comparateur de programmes et espace candidat (tête de liste).
 */
class CampagneController extends Controller
{
    private const MAX_PROPOSITIONS = 24;

    private const MAX_REALISATIONS = 12;

    /** Programmes des listes de l'UFR, côte à côte, thème par thème. */
    public function comparer()
    {
        $etudiant = Auth::user();

        return view('user.comparer', [
            'themes' => Proposition::THEMES,
            'listes' => Listes::where('ufr_id', $etudiant->ufr_id)
                ->where('campagne_validee', true)
                ->with('propositions')
                ->orderBy('name_list')
                ->get(),
        ]);
    }

    /** Logo d'une liste, servi depuis le stockage privé (pas de lien symbolique à créer). */
    public function logo($id)
    {
        $liste = Listes::findOrFail($id);
        $moi = Auth::guard('web')->user();

        // Visible par l'administration et par les étudiants de l'UFR concernée.
        abort_unless(Auth::guard('admin')->check() || ($moi && $moi->ufr_id === $liste->ufr_id), 404);
        abort_unless($liste->logo && Storage::disk('local')->exists($liste->logo), 404);

        return response()->file(Storage::disk('local')->path($liste->logo), [
            'Cache-Control' => 'private, max-age=300',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function maListe()
    {
        $liste = $this->maListeOuEchec();

        return view('user.maListe', [
            'liste' => $liste,
            'propositions' => $liste->propositions()->orderBy('theme')->orderBy('id')->get(),
            'realisations' => $liste->realisations,
            'themes' => Proposition::THEMES,
            'modifiable' => $this->modifiable($liste),
        ]);
    }

    public function majInfos(Request $request)
    {
        $liste = $this->listeModifiable();

        $donnees = $request->validate([
            'slogan' => 'nullable|string|max:160',
            'titre' => 'nullable|string|max:120',
            'programme' => 'required|string|max:10000',
            // Images matricielles uniquement : pas de SVG (qui peut embarquer du script).
            'logo' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:1024|dimensions:max_width=2000,max_height=2000',
        ], [], ['titre' => 'titre du programme', 'programme' => 'présentation']);

        if ($request->hasFile('logo')) {
            if ($liste->logo) {
                Storage::disk('local')->delete($liste->logo);
            }
            // Nom de fichier aléatoire généré par Laravel : rien ne vient du nom d'origine.
            $liste->logo = $request->file('logo')->store('logos', 'local');
        }

        $liste->fill([
            'slogan' => $donnees['slogan'] ?? null,
            'titre' => $donnees['titre'] ?? null,
            'programme' => $donnees['programme'],
            'campagne_validee' => false,
        ])->save();

        return back()->with('success', 'Page de campagne enregistrée. Elle sera publiée après validation par l\'administration.');
    }

    public function ajouterProposition(Request $request)
    {
        $liste = $this->listeModifiable();

        $donnees = $request->validate([
            'theme' => ['required', Rule::in(array_keys(Proposition::THEMES))],
            'texte' => 'required|string|max:400',
        ], [], ['theme' => 'thème', 'texte' => 'proposition']);

        if ($liste->propositions()->count() >= self::MAX_PROPOSITIONS) {
            return back()->with('error', 'Limite atteinte : '.self::MAX_PROPOSITIONS.' propositions au maximum.');
        }

        $liste->propositions()->create($donnees);
        $liste->update(['campagne_validee' => false]);

        return back()->with('success', 'Proposition ajoutée (en attente de validation).');
    }

    public function supprimerProposition($id)
    {
        $liste = $this->listeModifiable();
        $liste->propositions()->where('id', $id)->firstOrFail()->delete();
        $liste->update(['campagne_validee' => false]);

        return back()->with('success', 'Proposition supprimée.');
    }

    public function ajouterRealisation(Request $request)
    {
        $liste = $this->listeModifiable();

        $donnees = $request->validate([
            'annee' => ['nullable', 'string', 'max:9', 'regex:/^\d{4}([\-\/]\d{4})?$/'],
            'titre' => 'required|string|max:150',
            'description' => 'nullable|string|max:600',
        ], ['annee.regex' => "L'année doit être au format 2025 ou 2024-2025."], ['annee' => 'année']);

        if ($liste->realisations()->count() >= self::MAX_REALISATIONS) {
            return back()->with('error', 'Limite atteinte : '.self::MAX_REALISATIONS.' réalisations au maximum.');
        }

        $liste->realisations()->create($donnees);
        $liste->update(['campagne_validee' => false]);

        return back()->with('success', 'Réalisation ajoutée (en attente de validation).');
    }

    public function supprimerRealisation($id)
    {
        $liste = $this->listeModifiable();
        $liste->realisations()->where('id', $id)->firstOrFail()->delete();
        $liste->update(['campagne_validee' => false]);

        return back()->with('success', 'Réalisation supprimée.');
    }

    /** Seule la tête de liste accède à l'espace candidat. */
    private function maListeOuEchec(): Listes
    {
        $liste = Auth::user()->listeDirigee();
        abort_unless($liste, 403);

        return $liste;
    }

    /** La campagne se fige à la clôture du scrutin. */
    private function modifiable(Listes $liste): bool
    {
        return $liste->ufr?->scrutin?->statut !== 'clos';
    }

    private function listeModifiable(): Listes
    {
        $liste = $this->maListeOuEchec();
        abort_unless($this->modifiable($liste), 403, 'Le scrutin est clos : la page de campagne ne peut plus être modifiée.');

        return $liste;
    }
}
