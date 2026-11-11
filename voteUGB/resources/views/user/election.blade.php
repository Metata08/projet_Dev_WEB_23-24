@extends('layouts.app')
@section('titre', 'Élections')

@section('contenu')
@php($peutVoter = $scrutin && $scrutin->estOuvert() && ! $emargement)
<div class="container">
    <header class="page-tete">
        <div class="reveal">
            <span class="surtitre"><x-icon name="building" /> UFR {{ $etudiant->ufr?->sigle }}</span>
            <h1 class="titre-l">Votez pour votre <span class="texte-degrade">représentant</span></h1>
            <p class="chapo">Bonjour {{ ucfirst($etudiant->prenom) }}, découvrez les listes candidates de votre UFR, consultez leur programme et exprimez votre choix.</p>
            <div class="rangee">
                @include('partials.scrutin-etat')
                @if ($listes->count() > 1)<a class="btn btn-sm" href="{{ route('comparer') }}"><x-icon name="list" /> Comparer les programmes</a>@endif
            </div>
        </div>
        <div class="reveal" data-i="1">@include('partials.rebours')</div>
    </header>

    @if (session('vote_ok'))
        <canvas class="confettis" data-confettis aria-hidden="true"></canvas>
    @endif

    @if ($emargement)
        <div class="card card-pad succes-vote reveal">
            <span class="succes-coche"><x-icon name="check" /></span>
            <div>
                <h2 class="titre-m">A voté ! Merci pour votre participation.</h2>
                <p class="doux">Votre participation a été enregistrée le {{ $emargement->voted_at->format('d/m/Y à H:i') }}. Votre bulletin, lui, est anonyme.</p>
            </div>
            <a class="btn btn-primary" href="{{ route('resultat') }}"><x-icon name="chart" /> Voir les résultats</a>
        </div>

        @if (session('recu'))
            <div class="card card-pad recu reveal">
                <div>
                    <span class="surtitre"><x-icon name="shield" /> Votre reçu de vote</span>
                    <p class="recu-code" data-recu>{{ session('recu') }}</p>
                    <p class="doux petit"><strong>Notez-le maintenant : il ne sera plus jamais affiché.</strong> Il vous permet de vérifier que votre bulletin est bien dans l'urne, sans révéler votre choix.</p>
                </div>
                <div class="rangee">
                    <button type="button" class="btn" data-copier="[data-recu]"><x-icon name="file" /> <span>Copier</span></button>
                    <a class="btn btn-ghost" href="{{ route('recu') }}">Vérifier un reçu</a>
                </div>
            </div>
        @endif
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
                        @include('partials.sigle', ['liste' => $liste])
                    </div>
                    <div class="liste-corps">
                        <h2>{{ $liste->name_list }}</h2>
                        @if ($liste->slogan && $liste->campagne_validee)<p class="liste-slogan">« {{ $liste->slogan }} »</p>@endif
                        <div class="liste-meta">
                            @if ($tete)<span><x-icon name="user" /> {{ $tete->nom_complet }}</span>@endif
                            <span><x-icon name="users" /> {{ $liste->membres_count }} {{ $liste->membres_count > 1 ? 'membres' : 'membre' }}</span>
                        </div>
                        <div class="liste-actions">
                            <a class="btn" href="{{ route('detailListe', ['id' => $liste->id_list]) }}"><x-icon name="file" /> Campagne</a>
                            @if ($peutVoter)
                                <a class="btn btn-primary" href="{{ route('systemevote', ['id' => $liste->id_list]) }}">Voter <x-icon name="vote" /></a>
                            @else
                                <span class="btn btn-primary" aria-disabled="true" title="{{ $emargement ? 'Vous avez déjà voté' : 'Le scrutin n\'est pas ouvert' }}">{{ $emargement ? 'A voté' : 'Fermé' }} <x-icon name="{{ $emargement ? 'check' : 'lock' }}" /></span>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endsection
