<!DOCTYPE html>
<html lang="fr">
<head>
    @include('partials.head')
</head>
@php($moi = auth('web')->user())
<body>
    <a href="#contenu" class="skip-link">Aller au contenu</a>
    <div class="aurora" aria-hidden="true"><span></span><span></span><span></span></div>

    <header class="entete" data-entete>
        <div class="container">
            <div class="entete-barre">
                <a href="{{ route('ugbvote') }}" class="logo" aria-label="UGB Vote — accueil">
                    <img src="{{ asset('images/logo.png') }}" alt="UGB Vote" width="401" height="142">
                </a>

                <nav class="nav" id="menu" aria-label="Navigation principale">
                    @if ($moi)
                        <a class="nav-lien" href="{{ route('election') }}" @if (request()->routeIs('election', 'detailListe', 'systemevote', 'comparer')) aria-current="page" @endif>
                            <x-icon name="vote" /> Élections
                        </a>
                        <a class="nav-lien" href="{{ route('resultat') }}" @if (request()->routeIs('resultat', 'recu')) aria-current="page" @endif>
                            <x-icon name="chart" /> Résultats
                        </a>
                        @if ($moi->listeDirigee())
                            <a class="nav-lien" href="{{ route('maListe') }}" @if (request()->routeIs('maListe')) aria-current="page" @endif>
                                <x-icon name="sparkles" /> Ma liste
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="nav-mobile-seul" data-confirm="Voulez-vous vraiment vous déconnecter ?" data-confirm-titre="Déconnexion" data-confirm-action="Se déconnecter">
                            @csrf
                            <button type="submit" class="btn"><x-icon name="log-out" /> Se déconnecter</button>
                        </form>
                    @else
                        <a class="nav-lien" href="{{ route('ugbvote') }}#etapes">Comment ça marche</a>
                        <a class="nav-lien" href="{{ route('ugbvote') }}#garanties">Garanties</a>
                        <a class="nav-lien nav-mobile-seul" href="{{ route('inscription') }}">Créer un compte</a>
                        <a class="btn btn-primary nav-mobile-seul" href="{{ route('login') }}">Se connecter <x-icon name="log-in" /></a>
                    @endif
                </nav>

                <div class="entete-actions">
                    <button type="button" class="btn btn-ghost btn-icon theme-bascule" data-theme-bascule aria-label="Changer de thème (clair / sombre)">
                        <x-icon name="moon" class="icon-soleil" /><x-icon name="sun" class="icon-lune" />
                    </button>

                    @if ($moi)
                        <div class="profil" title="{{ $moi->nom_complet }}">
                            <span class="avatar" aria-hidden="true">{{ $moi->initiales }}</span>
                            <span class="profil-nom">
                                <strong>{{ ucfirst($moi->prenom) }}</strong>
                                <span>{{ mb_strtoupper($moi->nom) }}</span>
                            </span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="bureau-seul" data-confirm="Voulez-vous vraiment vous déconnecter ?" data-confirm-titre="Déconnexion" data-confirm-action="Se déconnecter">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-icon" aria-label="Se déconnecter" title="Se déconnecter"><x-icon name="log-out" /></button>
                        </form>
                    @else
                        <a class="btn btn-primary bureau-seul" href="{{ route('login') }}">Se connecter <x-icon name="log-in" /></a>
                    @endif

                    <button type="button" class="btn btn-ghost btn-icon menu-bascule" data-menu-bascule aria-controls="menu" aria-expanded="false" aria-label="Ouvrir le menu">
                        <x-icon name="menu" />
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main id="contenu">
        @yield('contenu')
    </main>

    <footer class="pied">
        <div class="container">
            <div class="pied-grille">
                <div>
                    <a href="{{ route('ugbvote') }}" class="logo" aria-label="UGB Vote — accueil">
                        <img src="{{ asset('images/logo.png') }}" alt="UGB Vote" width="401" height="142" loading="lazy">
                    </a>
                    <p class="petit">Votre avenir, votre voix.<br>Élisez des représentants engagés pour vous !</p>
                    <div class="reseaux">
                        <a href="https://www.ugb.sn" target="_blank" rel="noopener noreferrer" aria-label="Site de l'UGB"><x-icon name="globe" /></a>
                        <a href="https://portail.ugbnumerique.sn" target="_blank" rel="noopener noreferrer" aria-label="Portail UGB numérique"><x-icon name="building" /></a>
                        <a href="mailto:contact@ugb.edu.sn" aria-label="Écrire à l'UGB"><x-icon name="mail" /></a>
                    </div>
                </div>
                <div>
                    <h3>Plateforme</h3>
                    <ul>
                        <li><a href="{{ route('ugbvote') }}">Accueil</a></li>
                        <li><a href="{{ route('election') }}">Élections</a></li>
                        <li><a href="{{ route('resultat') }}">Résultats</a></li>
                        <li><a href="{{ route('recu') }}">Vérifier mon reçu de vote</a></li>
                        @guest('web')<li><a href="{{ route('inscription') }}">Créer un compte</a></li>@endguest
                    </ul>
                </div>
                <div>
                    <h3>Liens utiles</h3>
                    <ul>
                        <li><a href="https://www.ugb.sn" target="_blank" rel="noopener noreferrer">www.ugb.sn</a></li>
                        <li><a href="https://portail.ugbnumerique.sn" target="_blank" rel="noopener noreferrer">portail.ugbnumerique.sn</a></li>
                        <li><a href="{{ route('admin') }}">Espace administrateur</a></li>
                    </ul>
                </div>
            </div>
            <div class="pied-bas">
                <span>© {{ date('Y') }} UGBVote — Université Gaston Berger de Saint-Louis</span>
                <span class="rangee"><x-icon name="shield" /> Vote unique · sécurisé · transparent</span>
            </div>
        </div>
    </footer>

    @include('partials.toasts')
</body>
</html>
