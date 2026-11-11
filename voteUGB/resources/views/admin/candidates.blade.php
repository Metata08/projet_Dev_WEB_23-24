@extends('layouts.admin')
@section('titre', 'Listes')

@section('actions')
    <button type="button" class="btn btn-primary btn-sm" data-ouvrir="#modale-liste"><x-icon name="plus" /> <span class="bureau-seul">Ajouter une liste</span></button>
@endsection

@section('contenu')
<section class="card reveal">
    <div class="card-pad rangee entre">
        <div>
            <h2 class="titre-m">{{ $listesC->count() }} liste(s) candidate(s)</h2>
            <p class="doux petit">Les étudiants ne voient que les listes de leur UFR.</p>
        </div>
        <label class="recherche">
            <span class="sr-only">Rechercher une liste</span>
            <x-icon name="search" />
            <input type="search" placeholder="Rechercher une liste…" data-filtre="#table-listes">
        </label>
    </div>

    @if ($listesC->isEmpty())
        <div class="vide"><span class="pastille-icone"><x-icon name="list" /></span><h3 class="titre-m">Aucune liste</h3><p>Ajoutez la première liste candidate.</p></div>
    @else
        <div class="table-zone">
            <table class="table" id="table-listes">
                <thead>
                    <tr><th>Liste</th><th>UFR</th><th>Membres</th><th>Campagne</th><th class="droite">Actions</th></tr>
                </thead>
                <tbody>
                    @foreach ($listesC as $liste)
                        <tr>
                            <td class="principal">
                                <div class="identite">
                                    <span class="avatar" aria-hidden="true">{{ $liste->sigle }}</span>
                                    <div><strong>{{ $liste->name_list }}</strong><span class="tronque">{{ $liste->programme }}</span></div>
                                </div>
                            </td>
                            <td data-titre="UFR"><span class="pill pill-accent">{{ $liste->ufr?->sigle ?? '—' }}</span></td>
                            <td data-titre="Membres">{{ $liste->membres_count }}</td>
                            <td data-titre="Campagne">
                                @if ($liste->campagne_validee)
                                    <span class="pill pill-ok"><x-icon name="check" /> Publiée</span>
                                @else
                                    <span class="pill pill-alerte"><x-icon name="clock" /> À valider</span>
                                @endif
                            </td>
                            <td data-titre="Actions" class="droite actions">
                                <a class="btn btn-sm" href="{{ route('admin.liste', $liste->id_list) }}"><x-icon name="users" /> Gérer</a>
                                <form method="POST" action="{{ route('deleteListe', $liste->id_list) }}" data-confirm="Supprimer la liste « {{ $liste->name_list }} » ? Les bulletins qu'elle a reçus seront supprimés, mais les étudiants concernés resteront émargés et ne pourront pas revoter." data-confirm-titre="Supprimer la liste" data-confirm-action="Supprimer" data-confirm-danger>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" aria-label="Supprimer la liste {{ $liste->name_list }}"><x-icon name="trash" /> Supprimer</button>
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

<dialog class="modale" id="modale-liste" aria-labelledby="modale-liste-titre" @if ($errors->any()) data-ouverte @endif>
    <form method="POST" action="{{ route('enregistrerList') }}" data-envoi>
        @csrf
        <div class="modale-corps">
            <h2 class="titre-m" id="modale-liste-titre">Ajouter une liste</h2>
            <div class="champ">
                <label for="nom">Nom de la liste</label>
                <input class="sans-icone" type="text" id="nom" name="nom" value="{{ old('nom') }}" maxlength="120" required>
            </div>
            <div class="champ">
                <label for="ufr">UFR</label>
                <div class="champ-controle">
                    <select class="sans-icone" id="ufr" name="ufr" required>
                        <option value="">Sélectionnez une UFR</option>
                        @foreach ($ufrs as $ufr)
                            <option value="{{ $ufr->id_ufr }}" @selected(old('ufr') == $ufr->id_ufr)>{{ $ufr->sigle }}</option>
                        @endforeach
                    </select>
                    <x-icon name="chevron-down" class="champ-chevron" />
                </div>
            </div>
            <div class="champ">
                <label for="programme">Programme</label>
                <textarea id="programme" name="programme" maxlength="10000" required placeholder="Une proposition par ligne…">{{ old('programme') }}</textarea>
                <span class="champ-aide">Astuce : une proposition par ligne pour un affichage en liste à puces.</span>
            </div>
        </div>
        <div class="modale-actions">
            <button type="button" class="btn" data-fermer>Annuler</button>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </form>
</dialog>
@endsection
