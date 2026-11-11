@extends('layouts.app')
@section('titre', $liste->name_list)

@section('contenu')
@php($peutVoter = $scrutin && $scrutin->estOuvert() && ! $emargement)
<div class="container">
    <header class="page-tete">
        <div class="reveal">
            <a class="fil" href="{{ route('election') }}"><x-icon name="arrow-left" /> Toutes les listes</a>
            <div class="campagne-tete">
                <div class="campagne-sigle">@include('partials.sigle', ['liste' => $liste, 'afficherBrouillon' => $jeDirige])</div>
                <div>
                    <span class="surtitre"><x-icon name="sparkles" /> Page de campagne</span>
                    <h1 class="titre-l texte-degrade">{{ $liste->name_list }}</h1>
                    @if ($campagneVisible && $liste->slogan)<p class="chapo">« {{ $liste->slogan }} »</p>@endif
                </div>
            </div>
            <div class="rangee">
                @include('partials.scrutin-etat')
                @if ($jeDirige)<a class="btn btn-sm" href="{{ route('maListe') }}"><x-icon name="sparkles" /> Modifier ma page</a>@endif
            </div>
        </div>
    </header>

    @if ($jeDirige && ! $liste->campagne_validee)
        <div class="alerte reveal"><x-icon name="clock" /> <span>Vos dernières modifications sont <strong>en attente de validation</strong> : vous seul voyez cette version pour l'instant.</span></div>
    @endif

    <div class="detail">
        <div class="stack campagne-contenu">
            @if ($campagneVisible)
                @include('partials.campagne')
            @else
                <section class="card vide reveal">
                    <span class="pastille-icone"><x-icon name="clock" /></span>
                    <h2 class="titre-m">Page de campagne en cours de validation</h2>
                    <p>La liste a mis à jour sa page. Elle sera de nouveau visible dès que l'administration l'aura validée.</p>
                </section>
            @endif
        </div>

        <aside class="detail-colle stack">
            <section class="card card-pad reveal" data-i="1">
                <h2 class="titre-s">L'équipe</h2>
                @forelse ($membres as $membre)
                    @continue(! $membre->etudiant)
                    <div class="membre">
                        <span class="avatar" aria-hidden="true">{{ $membre->etudiant->initiales }}</span>
                        <div>
                            <strong>{{ $membre->etudiant->prenom }} {{ $membre->etudiant->nom }}</strong>
                            @if ($membre->role)<span class="doux petit">{{ $membre->role }}</span>@endif
                        </div>
                        @if ($membre->tete_liste)<span class="pill pill-accent"><x-icon name="trophy" /> Tête de liste</span>@endif
                    </div>
                @empty
                    <p class="doux petit">La composition de la liste n'a pas encore été publiée.</p>
                @endforelse
            </section>

            <section class="card card-pad reveal stack" data-i="2">
                @if ($peutVoter)
                    <h2 class="titre-s">Convaincu ?</h2>
                    <p class="doux petit">Votre vote est définitif : prenez le temps de comparer les programmes.</p>
                    <a class="btn btn-primary btn-lg btn-block" href="{{ route('systemevote', ['id' => $liste->id_list]) }}">Voter pour cette liste <x-icon name="vote" /></a>
                    <a class="btn btn-block" href="{{ route('comparer') }}"><x-icon name="list" /> Comparer les programmes</a>
                @elseif ($emargement)
                    <div class="alerte alerte-succes"><x-icon name="check-circle" /> <span>Vous avez déjà voté pour ce scrutin.</span></div>
                    <a class="btn btn-block" href="{{ route('resultat') }}"><x-icon name="chart" /> Voir les résultats</a>
                @else
                    <div class="alerte"><x-icon name="lock" /> <span>Le scrutin n'est pas ouvert actuellement.</span></div>
                @endif
            </section>
        </aside>
    </div>
</div>
@endsection
