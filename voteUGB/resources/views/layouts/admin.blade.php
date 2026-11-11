<!DOCTYPE html>
<html lang="fr">
<head>
    @include('partials.head')
</head>
@php($admin = auth('admin')->user())
<body>
    <div class="aurora" aria-hidden="true"><span></span><span></span><span></span></div>

    <div class="admin" data-admin>
        <aside class="admin-lateral" id="menu-admin">
            <a href="{{ route('dashboardAdmin') }}" class="logo" aria-label="UGB Vote — tableau de bord">
                <img src="{{ asset('images/logo.png') }}" alt="UGB Vote" width="401" height="142">
            </a>

            <nav class="admin-nav" aria-label="Navigation administrateur">
                <h2>Rapports</h2>
                <ul>
                    <li><a href="{{ route('dashboardAdmin') }}" @if (request()->routeIs('dashboardAdmin')) aria-current="page" @endif><x-icon name="dashboard" /> Tableau de bord</a></li>
                    <li><a href="{{ route('admin.journal') }}" @if (request()->routeIs('admin.journal')) aria-current="page" @endif><x-icon name="clock" /> Journal</a></li>
                </ul>
            </nav>
            <nav class="admin-nav" aria-label="Gestion">
                <h2>Gérer</h2>
                <ul>
                    <li><a href="{{ route('listeElecteurs') }}" @if (request()->routeIs('listeElecteurs')) aria-current="page" @endif><x-icon name="users" /> Électeurs</a></li>
                    <li><a href="{{ route('listeCandidats') }}" @if (request()->routeIs('listeCandidats', 'admin.liste')) aria-current="page" @endif><x-icon name="list" /> Listes</a></li>
                    <li><a href="{{ route('listePostes') }}" @if (request()->routeIs('listePostes', 'admin.pv')) aria-current="page" @endif><x-icon name="calendar" /> Scrutins</a></li>
                    <li><a href="{{ route('admin.codes') }}" @if (request()->routeIs('admin.codes')) aria-current="page" @endif><x-icon name="id" /> Codes étudiants</a></li>
                </ul>
            </nav>

            <nav class="admin-nav admin-lateral-bas" aria-label="Session">
                <ul>
                    <li><a href="{{ route('ugbvote') }}"><x-icon name="home" /> Voir le site</a></li>
                    <li>
                        <form method="POST" action="{{ route('logoutAdmin') }}" data-confirm="Fermer la session administrateur ?" data-confirm-titre="Déconnexion" data-confirm-action="Se déconnecter">
                            @csrf
                            <button type="submit"><x-icon name="log-out" /> Déconnexion</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>
        <button type="button" class="admin-voile" data-admin-fermer aria-label="Fermer le menu"></button>

        <div class="admin-principal">
            <header class="admin-barre">
                <button type="button" class="btn btn-ghost btn-icon admin-menu" data-admin-ouvrir aria-controls="menu-admin" aria-label="Ouvrir le menu"><x-icon name="menu" /></button>
                <h1>@yield('titre')</h1>
                <span class="espace"></span>
                @yield('actions')
                <button type="button" class="btn btn-ghost btn-icon theme-bascule" data-theme-bascule aria-label="Changer de thème (clair / sombre)">
                    <x-icon name="moon" class="icon-soleil" /><x-icon name="sun" class="icon-lune" />
                </button>
                <div class="profil" title="{{ $admin?->email }}">
                    <span class="avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($admin?->name ?? 'A', 0, 1)) }}</span>
                    <span class="profil-nom bureau-seul"><strong>{{ $admin?->name }}</strong><span>Administrateur</span></span>
                </div>
            </header>

            <main class="admin-contenu" id="contenu">
                @if ($errors->any())
                    <div class="alerte alerte-erreur" role="alert"><x-icon name="alert" /> <span>{{ $errors->first() }}</span></div>
                @endif
                @yield('contenu')
            </main>
        </div>
    </div>

    @include('partials.toasts')
</body>
</html>
