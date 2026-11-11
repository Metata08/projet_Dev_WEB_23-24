@extends('layouts.app')
@section('titre', 'Résultats')

@section('contenu')
<div class="container" data-resultats="{{ route('resultats.json') }}">
    <script type="application/json" data-initial>@json($donnees)</script>

    <header class="page-tete">
        <div class="reveal">
            <span class="surtitre"><x-icon name="building" /> UFR {{ $donnees['ufr'] }}</span>
            <h1 class="titre-l">Résultats <span class="texte-degrade">en direct</span></h1>
            <div class="rangee">
                @include('partials.scrutin-etat')
                <span class="pill"><x-icon name="refresh" /> Mis à jour à <span data-maj>{{ $donnees['maj'] }}</span></span>
            </div>
        </div>
        <div class="reveal" data-i="1">@include('partials.rebours')</div>
    </header>

    <div class="tuiles">
        <div class="card tuile reveal"><span class="pastille-icone"><x-icon name="vote" /></span><div><strong data-total>{{ $donnees['total_votes'] }}</strong><span>Votes exprimés</span></div></div>
        <div class="card tuile reveal" data-i="1"><span class="pastille-icone"><x-icon name="users" /></span><div><strong data-inscrits>{{ $donnees['inscrits'] }}</strong><span>Étudiants inscrits</span></div></div>
        <div class="card tuile reveal" data-i="2"><span class="pastille-icone"><x-icon name="chart" /></span><div><strong><span data-participation>{{ $donnees['participation'] }}</span> %</strong><span>Participation</span></div></div>
    </div>

    <div class="resultats">
        <section class="card card-pad reveal">
            <h2 class="titre-m">Classement des listes</h2>
            <ol class="classement" data-classement>
                @forelse ($donnees['resultats'] as $i => $ligne)
                    <li class="{{ $ligne['en_tete'] ? 'en-tete' : '' }}" data-liste="{{ $ligne['id'] }}">
                        <div class="rang-tete">
                            <span class="rang-num">#{{ $i + 1 }}</span>
                            <h3>{{ $ligne['liste'] }}</h3>
                            <span class="couronne" title="En tête"><x-icon name="trophy" /></span>
                            <span class="voix"><span data-voix>{{ $ligne['votes'] }}</span> voix</span>
                            <span class="pct"><span data-pct>{{ $ligne['pourcentage'] }}</span> %</span>
                        </div>
                        <div class="jauge" role="img" aria-label="{{ $ligne['pourcentage'] }} % des voix"><b data-largeur="{{ $ligne['pourcentage'] }}"></b></div>
                    </li>
                @empty
                    <li class="doux">Aucune liste candidate pour cette UFR.</li>
                @endforelse
            </ol>
        </section>

        <aside class="card card-pad reveal" data-i="1">
            <h2 class="titre-m">Répartition des voix</h2>
            <div class="anneau">
                <svg viewBox="0 0 120 120" data-anneau aria-hidden="true">
                    <circle class="piste" cx="60" cy="60" r="50"/>
                    @foreach ($donnees['resultats'] as $i => $ligne)
                        <circle class="arc serie-{{ $i % 6 + 1 }}" cx="60" cy="60" r="50" data-arc="{{ $ligne['id'] }}"/>
                    @endforeach
                </svg>
                <div class="anneau-centre"><strong data-total>{{ $donnees['total_votes'] }}</strong><span>votes</span></div>
            </div>
            <ul class="legende">
                @foreach ($donnees['resultats'] as $i => $ligne)
                    <li data-legende="{{ $ligne['id'] }}"><i class="serie-{{ $i % 6 + 1 }}"></i><span>{{ $ligne['liste'] }}</span><b><span data-pct>{{ $ligne['pourcentage'] }}</span> %</b></li>
                @endforeach
            </ul>
        </aside>
    </div>
</div>
@endsection
