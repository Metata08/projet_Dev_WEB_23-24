@extends('layouts.admin')
@section('titre', $liste->name_list)

@section('actions')
    <a class="btn btn-sm bureau-seul" href="{{ route('listeCandidats') }}"><x-icon name="arrow-left" /> Toutes les listes</a>
@endsection

@section('contenu')
<section class="card card-pad rangee entre reveal">
    <div class="rangee">
        @include('partials.sigle', ['liste' => $liste, 'afficherBrouillon' => true])
        <div>
            <h2 class="titre-m">{{ $liste->name_list }}</h2>
            <p class="doux petit">UFR {{ $liste->ufr?->sigle }}@if ($liste->slogan) · « {{ $liste->slogan }} »@endif</p>
        </div>
    </div>
    @if ($liste->campagne_validee)
        <span class="pill pill-ok"><x-icon name="check" /> Page de campagne publiée</span>
    @else
        <form method="POST" action="{{ route('admin.liste.valider', $liste->id_list) }}" data-envoi class="rangee">
            @csrf
            <span class="pill pill-alerte"><x-icon name="clock" /> Modifications à relire</span>
            <button type="submit" class="btn btn-primary"><x-icon name="check" /> Valider et publier</button>
        </form>
    @endif
</section>

<div class="detail">
    <div class="stack campagne-contenu">
        @include('partials.campagne', ['realisations' => $liste->realisations])
    </div>

    <aside class="stack">
        <section class="card card-pad reveal">
            <h2 class="titre-s">Membres de la liste</h2>
            @forelse ($membres as $membre)
                @continue(! $membre->etudiant)
                <div class="membre">
                    <span class="avatar" aria-hidden="true">{{ $membre->etudiant->initiales }}</span>
                    <div>
                        <strong>{{ $membre->etudiant->prenom }} {{ $membre->etudiant->nom }}</strong>
                        <span class="doux petit">{{ $membre->tete_liste ? 'Tête de liste' : 'Membre' }}@if ($membre->role) · {{ $membre->role }}@endif</span>
                    </div>
                    <form method="POST" action="{{ route('admin.liste.membre.retirer', [$liste->id_list, $membre->id]) }}" data-confirm="Retirer {{ ucfirst($membre->etudiant->prenom) }} de la liste ?" data-confirm-titre="Retirer le membre" data-confirm-action="Retirer" data-confirm-danger>
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-icon btn-sm" aria-label="Retirer {{ $membre->etudiant->prenom }}"><x-icon name="trash" /></button>
                    </form>
                </div>
            @empty
                <p class="doux petit">Aucun membre pour l'instant.</p>
            @endforelse
        </section>

        <section class="card card-pad reveal" data-i="1">
            <h2 class="titre-s">Ajouter un membre</h2>
            @if ($candidats->isEmpty())
                <p class="doux petit">Tous les étudiants inscrits de cette UFR sont déjà membres.</p>
            @else
                <form method="POST" action="{{ route('admin.liste.membre', $liste->id_list) }}" class="champs" data-envoi>
                    @csrf
                    <div class="champ">
                        <label for="etudiant">Étudiant de l'UFR {{ $liste->ufr?->sigle }}</label>
                        <div class="champ-controle">
                            <select class="sans-icone" id="etudiant" name="etudiant" required>
                                <option value="">Choisir…</option>
                                @foreach ($candidats as $candidat)
                                    <option value="{{ $candidat->id_etudiant }}">{{ $candidat->nom_complet }} — {{ $candidat->code_etudiant }}</option>
                                @endforeach
                            </select>
                            <x-icon name="chevron-down" class="champ-chevron" />
                        </div>
                    </div>
                    <div class="champ">
                        <label for="role">Rôle <span class="doux">(facultatif)</span></label>
                        <input class="sans-icone" type="text" id="role" name="role" maxlength="80" placeholder="Trésorier, chargée de communication…">
                    </div>
                    <label class="case">
                        <input type="checkbox" name="tete_liste" value="1">
                        <span>Tête de liste <span class="doux petit">(remplace l'actuelle et donne accès à l'espace candidat)</span></span>
                    </label>
                    <button type="submit" class="btn btn-block"><x-icon name="plus" /> Ajouter</button>
                </form>
            @endif
        </section>
    </aside>
</div>
@endsection
