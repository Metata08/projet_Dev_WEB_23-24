@extends('layouts.app')

@section('contenu')
@php
    $titre = ['Élection', 'du', 'représentant', 'des', 'étudiants'];
    $etapes = [
        ["S'inscrire", 'Créez votre compte avec votre code étudiant officiel.'],
        ['Se connecter', 'Accédez à votre espace personnel sécurisé.'],
        ['Choisir une liste', 'Comparez les listes et leurs programmes.'],
        ['Voter', 'Exprimez votre choix : un vote, une voix.'],
        ['Résultats', 'Suivez le dépouillement en temps réel.'],
    ];
@endphp

<section class="hero">
    <canvas class="hero-toile" data-particules aria-hidden="true"></canvas>
    <div class="container hero-grille">
        <div class="hero-texte">
            <span class="pill"><span class="point point-vif"></span> Université Gaston Berger · Saint-Louis</span>
            <h1 class="titre-xl">
                @foreach ($titre as $i => $mot)
                    <span class="mot @if ($i === 2) texte-degrade @endif" data-i="{{ $i }}">{{ $mot }}</span>
                @endforeach
            </h1>
            <p class="chapo reveal"><strong>Votre avenir, votre voix.</strong> Élisez des représentants engagés pour vous, depuis votre téléphone, votre tablette ou votre ordinateur — en quelques secondes.</p>
            <div class="hero-cta reveal" data-i="1">
                @auth('web')
                    <a class="btn btn-primary btn-lg" href="{{ route('election') }}">Accéder au vote <x-icon name="arrow-right" class="icon-fleche" /></a>
                    <a class="btn btn-lg" href="{{ route('resultat') }}"><x-icon name="chart" /> Résultats en direct</a>
                @else
                    <a class="btn btn-primary btn-lg" href="{{ route('login') }}">Se connecter <x-icon name="arrow-right" class="icon-fleche" /></a>
                    <a class="btn btn-lg" href="{{ route('inscription') }}">Créer mon compte</a>
                @endauth
            </div>
            <ul class="hero-preuves reveal" data-i="2">
                <li><x-icon name="check-circle" /> Un seul vote par étudiant</li>
                <li><x-icon name="check-circle" /> Résultats en temps réel</li>
                <li><x-icon name="check-circle" /> 100 % responsive</li>
            </ul>
        </div>

        <div class="scene reveal" data-i="2" data-inclinaison>
            <div class="scene-carte" data-inclinaison-cible>
                <div class="scene-entete">
                    <span class="rangee"><x-icon name="vote" /> Urne numérique</span>
                    <span class="pill pill-ok"><span class="point point-vif"></span> En direct</span>
                </div>
                <svg class="urne" viewBox="0 0 320 210" role="img" aria-label="Un bulletin glisse dans l'urne">
                    <defs>
                        <linearGradient id="g-urne" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0" stop-color="#ab775b"/><stop offset="1" stop-color="#522504"/>
                        </linearGradient>
                        <clipPath id="c-fente"><rect x="0" y="-60" width="320" height="162"/></clipPath>
                    </defs>
                    <g clip-path="url(#c-fente)">
                        <g class="bulletin">
                            <rect x="118" y="26" width="84" height="64" rx="7" fill="#fff" stroke="#e7d2c2" stroke-width="2"/>
                            <path d="M134 50h34M134 62h52M134 74h24" stroke="#d3a98f" stroke-width="5" stroke-linecap="round"/>
                            <path d="m172 46 6 6 11-12" fill="none" stroke="#522504" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                    </g>
                    <rect x="56" y="100" width="208" height="16" rx="8" fill="#3d1b04"/>
                    <rect x="112" y="105" width="96" height="6" rx="3" fill="#1c0b01"/>
                    <path d="M66 116h188l-10 78a10 10 0 0 1-10 9H86a10 10 0 0 1-10-9z" fill="url(#g-urne)"/>
                    <text x="160" y="170" text-anchor="middle" fill="#f0e0d0" font-family="Sora, sans-serif" font-weight="700" font-size="26" letter-spacing="6">VOTE</text>
                    <g class="eclat" fill="#ab775b">
                        <circle cx="96" cy="88" r="4"/><circle cx="224" cy="88" r="4"/><circle cx="74" cy="72" r="3"/><circle cx="246" cy="72" r="3"/><circle cx="160" cy="70" r="3"/>
                    </g>
                </svg>
                <div class="scene-barres" data-demo-barres>
                    <div class="mini-barre"><span>Liste A</span><i><b data-largeur="64"></b></i><span>64 %</span></div>
                    <div class="mini-barre"><span>Liste B</span><i><b data-largeur="27"></b></i><span>27 %</span></div>
                    <div class="mini-barre"><span>Liste C</span><i><b data-largeur="9"></b></i><span>9 %</span></div>
                </div>
            </div>
            <div class="bulle bulle-1"><x-icon name="check-circle" /> A voté !</div>
            <div class="bulle bulle-2"><x-icon name="shield" /> Vote unique garanti</div>
        </div>
    </div>
</section>

<section class="section-serree">
    <div class="container">
        <div class="card chiffres reveal">
            <div class="chiffre"><strong data-compteur="{{ $chiffres['ufr'] }}">{{ $chiffres['ufr'] }}</strong><span>UFR participantes</span></div>
            <div class="chiffre"><strong data-compteur="{{ $chiffres['listes'] }}">{{ $chiffres['listes'] }}</strong><span>Listes candidates</span></div>
            <div class="chiffre"><strong data-compteur="{{ $chiffres['inscrits'] }}">{{ $chiffres['inscrits'] }}</strong><span>Étudiants inscrits</span></div>
            <div class="chiffre"><strong data-compteur="{{ $chiffres['votes'] }}">{{ $chiffres['votes'] }}</strong><span>Votes exprimés</span></div>
        </div>
    </div>
</section>

<section class="section" id="etapes">
    <div class="container">
        <div class="centre stack reveal">
            <span class="surtitre"><x-icon name="sparkles" /> Comment ça marche</span>
            <h2 class="titre-l">Voter en cinq étapes, sans file d'attente</h2>
            <p class="chapo">Du premier clic à la proclamation des résultats, tout se passe en ligne.</p>
        </div>
        <ol class="etapes" data-progres>
            @foreach ($etapes as $i => [$nom, $texte])
                <li class="card card-survol halo etape reveal" data-i="{{ $i }}">
                    <span class="etape-num">{{ $i + 1 }}</span>
                    <h3 class="titre-s">{{ $nom }}</h3>
                    <p>{{ $texte }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>

<section class="section" id="garanties">
    <div class="container">
        <div class="centre stack reveal">
            <span class="surtitre"><x-icon name="shield" /> Nos garanties</span>
            <h2 class="titre-l">Une élection transparente, accessible et fiable</h2>
        </div>
        <div class="bento">
            <article class="card card-pad card-survol halo large reveal">
                <span class="pastille-icone"><x-icon name="lock" /></span>
                <h3 class="titre-m">Un étudiant, un vote</h3>
                <p>Chaque bulletin est rattaché à un compte vérifié. Le double vote est bloqué par la base de données elle-même : aucune fraude possible, même en cas de clics multiples.</p>
            </article>
            <article class="card card-pad card-survol halo large reveal" data-i="1">
                <span class="pastille-icone"><x-icon name="zap" /></span>
                <h3 class="titre-m">Résultats en temps réel</h3>
                <p>Le dépouillement se met à jour automatiquement, sans recharger la page. Suivez la participation et le classement des listes à la seconde près.</p>
            </article>
            <article class="card card-pad card-survol halo reveal">
                <span class="pastille-icone"><x-icon name="id" /></span>
                <h3 class="titre-s">Réservé aux étudiants validés</h3>
                <p>L'inscription exige un code étudiant officiel reconnu par l'université.</p>
            </article>
            <article class="card card-pad card-survol halo reveal" data-i="1">
                <span class="pastille-icone"><x-icon name="building" /></span>
                <h3 class="titre-s">Chaque UFR, son scrutin</h3>
                <p>Vous ne voyez et ne votez que pour les listes de votre propre UFR.</p>
            </article>
            <article class="card card-pad card-survol halo reveal" data-i="2">
                <span class="pastille-icone"><x-icon name="smartphone" /></span>
                <h3 class="titre-s">Partout, sur tout écran</h3>
                <p>Mobile, tablette, ordinateur : l'interface s'adapte, en clair comme en sombre.</p>
            </article>
        </div>
    </div>
</section>

<section class="section-serree">
    <div class="container">
        <div class="bandeau reveal">
            <h2 class="titre-l">Votre avenir, votre voix.</h2>
            <p>Élisez des représentants engagés pour vous !</p>
            @auth('web')
                <a class="btn btn-lg" href="{{ route('election') }}">Voter maintenant <x-icon name="arrow-right" class="icon-fleche" /></a>
            @else
                <a class="btn btn-lg" href="{{ route('inscription') }}">Je m'inscris <x-icon name="arrow-right" class="icon-fleche" /></a>
            @endauth
        </div>
    </div>
</section>
@endsection
