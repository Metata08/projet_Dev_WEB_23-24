@extends('layouts.app')
@section('titre', 'Élections')

@section('contenu')
@php($peutVoter = $scrutin && $scrutin->estOuvert() && ! $bulletin)
<div class="container">
    <header class="page-tete">
        <div class="reveal">
            <span class="surtitre"><x-icon name="building" /> UFR {{ $etudiant->ufr?->sigle }}</span>
            <h1 class="titre-l">Votez pour votre <span class="texte-degrade">représentant</span></h1>
            <p class="chapo">Bonjour {{ ucfirst($etudiant->prenom) }}, découvrez les listes candidates de votre UFR, consultez leur programme et exprimez votre choix.</p>
            <div class="rangee">@include('partials.scrutin-etat')</div>
        </div>
        <div class="reveal" data-i="1">@include('partials.rebours')</div>
    </header>

    @if (session('vote_ok'))
        <canvas class="confettis" data-confettis aria-hidden="true"></canvas>
    @endif

    @if ($bulletin)
        <div class="card card-pad succes-vote reveal">
            <span class="succes-coche"><x-icon name="check" /></span>
            <div>
                <h2 class="titre-m">A voté ! Merci pour votre participation.</h2>
                <p class="doux">Votre bulletin a été enregistré le {{ $bulletin->voted_at->format('d/m/Y à H:i') }}. Un seul vote est autorisé par étudiant.</p>
            </div>
            <a class="btn btn-primary" href="{{ route('resultat') }}"><x-icon name="chart" /> Voir les résultats</a>
        </div>
    @endif

    @if ($listes->isEmpty())
        <div class="card vide reveal">
            <span class="pastille-icone"><x-icon name="list" /></span>
            <h2 class="titre-m">Aucune liste pour l'instant</h2>
            <p>Aucune liste n'est encore déclarée pour votre UFR. Revenez un peu plus tard.</p>
        </div>
    @else
        <div class="grille-listes">
            @foreach ($listes as $i => $liste)
                @php($tete = $liste->membres->first()?->etudiant)
                <article class="card card-survol halo liste-carte ton-{{ $i % 4 + 1 }} reveal" data-i="{{ $i % 3 }}" data-inclinaison data-inclinaison-force="5">
                    <div class="liste-visuel">
                        <span class="liste-numero">LISTE {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="liste-sigle" aria-hidden="true">{{ mb_strtoupper(mb_substr($liste->name_list, 0, 1)) }}</span>
                    </div>
                    <div class="liste-corps">
                        <h2>{{ $liste->name_list }}</h2>
                        <div class="liste-meta">
                            @if ($tete)<span><x-icon name="user" /> {{ $tete->nom_complet }}</span>@endif
                            <span><x-icon name="users" /> {{ $liste->membres_count }} {{ $liste->membres_count > 1 ? 'membres' : 'membre' }}</span>
                        </div>
                        <div class="liste-actions">
                            <a class="btn" href="{{ route('detailListe', ['id' => $liste->id_list]) }}"><x-icon name="file" /> Programme</a>
                            @if ($peutVoter)
                                <a class="btn btn-primary" href="{{ route('systemevote', ['id' => $liste->id_list]) }}">Voter <x-icon name="vote" /></a>
                            @else
                                <span class="btn btn-primary" aria-disabled="true" title="{{ $bulletin ? 'Vous avez déjà voté' : 'Le scrutin n\'est pas ouvert' }}">{{ $bulletin ? 'A voté' : 'Fermé' }} <x-icon name="{{ $bulletin ? 'check' : 'lock' }}" /></span>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endsection
