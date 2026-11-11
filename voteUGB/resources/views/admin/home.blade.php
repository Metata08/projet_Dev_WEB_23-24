@extends('layouts.admin')
@section('titre', 'Tableau de bord')

@section('actions')
    <span class="pill pill-ok bureau-seul"><span class="point point-vif"></span> En direct · <span data-maj>{{ $stats['maj'] }}</span></span>
    <button type="button" class="btn btn-sm bureau-seul" data-imprimer><x-icon name="printer" /> Imprimer</button>
@endsection

@section('contenu')
<div data-tableau-de-bord="{{ route('admin.stats') }}" class="stack">
    <script type="application/json" data-initial>@json($stats)</script>

    <div class="tuiles">
        <div class="card tuile reveal"><span class="pastille-icone"><x-icon name="building" /></span><div><strong data-stat="ufr">{{ $stats['ufr'] }}</strong><span>UFR</span></div></div>
        <div class="card tuile reveal" data-i="1"><span class="pastille-icone"><x-icon name="list" /></span><div><strong data-stat="listes">{{ $stats['listes'] }}</strong><span>Listes candidates</span></div></div>
        <div class="card tuile reveal" data-i="2"><span class="pastille-icone"><x-icon name="users" /></span><div><strong data-stat="inscrits">{{ $stats['inscrits'] }}</strong><span>Électeurs inscrits</span></div></div>
        <div class="card tuile reveal" data-i="3"><span class="pastille-icone"><x-icon name="vote" /></span><div><strong data-stat="votants">{{ $stats['votants'] }}</strong><span>Ont voté</span></div></div>
    </div>

    <div class="resultats">
        <section class="card card-pad reveal">
            <div class="rangee entre">
                <h2 class="titre-m">Décompte des votes par UFR</h2>
                <span class="pill"><x-icon name="refresh" /> Actualisation automatique</span>
            </div>
            <div data-decompte>
                @foreach ($stats['parUfr'] as $bloc)
                    <div class="ufr-bloc" data-ufr="{{ $bloc['ufr'] }}">
                        <div class="rangee entre">
                            <h3 class="titre-s">UFR {{ $bloc['ufr'] }}</h3>
                            <span class="petit doux"><span data-ufr-total>{{ $bloc['total_votes'] }}</span> vote(s) · <span data-ufr-part>{{ $bloc['participation'] }}</span> % de participation</span>
                        </div>
                        <ol class="classement">
                            @forelse ($bloc['resultats'] as $ligne)
                                <li class="{{ $ligne['en_tete'] ? 'en-tete' : '' }}" data-liste="{{ $ligne['id'] }}">
                                    <div class="rang-tete">
                                        <h3>{{ $ligne['liste'] }}</h3>
                                        <span class="couronne" title="En tête"><x-icon name="trophy" /></span>
                                        <span class="voix"><span data-voix>{{ $ligne['votes'] }}</span> voix</span>
                                        <span class="pct"><span data-pct>{{ $ligne['pourcentage'] }}</span> %</span>
                                    </div>
                                    <div class="jauge"><b data-largeur="{{ $ligne['pourcentage'] }}"></b></div>
                                </li>
                            @empty
                                <li class="doux petit">Aucune liste déclarée.</li>
                            @endforelse
                        </ol>
                    </div>
                @endforeach
            </div>
        </section>

        <aside class="card card-pad reveal" data-i="1">
            <h2 class="titre-m">Participation globale</h2>
            <div class="anneau">
                <svg viewBox="0 0 120 120" aria-hidden="true">
                    <circle class="piste" cx="60" cy="60" r="50"/>
                    <circle class="arc serie-2" cx="60" cy="60" r="50" data-jauge-participation/>
                </svg>
                <div class="anneau-centre"><strong><span data-stat="participation">{{ $stats['participation'] }}</span>%</strong><span>des inscrits</span></div>
            </div>
            <ul class="legende">
                <li><i class="serie-2"></i><span>Ont voté</span><b data-stat="votants">{{ $stats['votants'] }}</b></li>
                <li><i class="serie-3"></i><span>Inscrits</span><b data-stat="inscrits">{{ $stats['inscrits'] }}</b></li>
            </ul>
        </aside>
    </div>
</div>
@endsection
