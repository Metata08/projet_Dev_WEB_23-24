@extends('layouts.app')
@section('titre', $liste->name_list)

@section('contenu')
@php
    $peutVoter = $scrutin && $scrutin->estOuvert() && ! $bulletin;
    $points = collect(preg_split('/\R+/u', trim($liste->programme)))->map(fn ($l) => trim($l))->filter()->values();
@endphp
<div class="container">
    <header class="page-tete">
        <div class="reveal">
            <a class="fil" href="{{ route('election') }}"><x-icon name="arrow-left" /> Toutes les listes</a>
            <span class="surtitre"><x-icon name="file" /> Programme de la liste</span>
            <h1 class="titre-l texte-degrade">{{ $liste->name_list }}</h1>
            <div class="rangee">@include('partials.scrutin-etat')</div>
        </div>
    </header>

    <div class="detail">
        <section class="card card-pad reveal">
            <h2 class="titre-m">{{ $liste->titre ?: 'Nos engagements' }}</h2>
            @if ($points->count() > 1)
                <ul class="programme-points">
                    @foreach ($points as $point)
                        <li><x-icon name="check-circle" /> <span>{{ $point }}</span></li>
                    @endforeach
                </ul>
            @else
                <p class="programme-texte">{{ $liste->programme }}</p>
            @endif
        </section>

        <aside class="detail-colle stack">
            <section class="card card-pad reveal" data-i="1">
                <h2 class="titre-s">Membres de la liste</h2>
                @forelse ($membres as $membre)
                    @continue(! $membre->etudiant)
                    <div class="membre">
                        <span class="avatar" aria-hidden="true">{{ $membre->etudiant->initiales }}</span>
                        <strong>{{ $membre->etudiant->prenom }} {{ $membre->etudiant->nom }}</strong>
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
                @elseif ($bulletin)
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
