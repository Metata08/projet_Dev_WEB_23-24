@extends('layouts.admin')
@section('titre', 'Électeurs')

@section('contenu')
<section class="card reveal">
    <div class="card-pad rangee entre">
        <div>
            <h2 class="titre-m">{{ $etudiants->count() }} électeur(s) inscrit(s)</h2>
            <p class="doux petit">Étudiants ayant créé un compte avec un code officiel.</p>
        </div>
        <label class="recherche">
            <span class="sr-only">Rechercher un électeur</span>
            <x-icon name="search" />
            <input type="search" placeholder="Rechercher un nom, un code, une UFR…" data-filtre="#table-electeurs">
        </label>
    </div>

    @if ($etudiants->isEmpty())
        <div class="vide"><span class="pastille-icone"><x-icon name="users" /></span><h3 class="titre-m">Aucun électeur</h3><p>Aucun étudiant ne s'est encore inscrit.</p></div>
    @else
        <div class="table-zone">
            <table class="table" id="table-electeurs">
                <thead>
                    <tr><th>Électeur</th><th>Code étudiant</th><th>UFR</th><th>Vote</th><th class="droite">Action</th></tr>
                </thead>
                <tbody>
                    @foreach ($etudiants as $etudiant)
                        <tr>
                            <td class="principal">
                                <div class="identite">
                                    <span class="avatar" aria-hidden="true">{{ $etudiant->initiales }}</span>
                                    <div><strong>{{ $etudiant->prenom }} {{ $etudiant->nom }}</strong><span>{{ $etudiant->email }}</span></div>
                                </div>
                            </td>
                            <td data-titre="Code"><span class="mono">{{ $etudiant->code_etudiant }}</span></td>
                            <td data-titre="UFR"><span class="pill pill-accent">{{ $etudiant->ufr?->sigle ?? '—' }}</span></td>
                            <td data-titre="Vote">
                                @if ($etudiant->bulletins_count > 0)
                                    <span class="pill pill-ok"><x-icon name="check" /> A voté</span>
                                @else
                                    <span class="pill">En attente</span>
                                @endif
                            </td>
                            <td data-titre="Action" class="droite">
                                <form method="POST" action="{{ route('deleteElecteur', $etudiant->id_etudiant) }}" data-confirm="Supprimer définitivement {{ ucfirst($etudiant->prenom) }} {{ mb_strtoupper($etudiant->nom) }} ? Son éventuel bulletin sera également supprimé." data-confirm-titre="Supprimer l'électeur" data-confirm-action="Supprimer" data-confirm-danger>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" aria-label="Supprimer {{ $etudiant->prenom }} {{ $etudiant->nom }}"><x-icon name="trash" /> Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p class="vide doux" data-aucun hidden>Aucun résultat pour cette recherche.</p>
        </div>
    @endif
</section>
@endsection
