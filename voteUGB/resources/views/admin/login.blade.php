@extends('layouts.app')
@section('titre', 'Administration')

@section('contenu')
<div class="container auth">
    <aside class="auth-visuel reveal">
        <div>
            <span class="pill"><x-icon name="shield" /> Accès restreint</span>
            <h2>Pilotez l'élection en toute confiance.</h2>
            <p>Tableau de bord temps réel, gestion des électeurs, des listes et des périodes de scrutin.</p>
        </div>
        <ul class="auth-points">
            <li><x-icon name="dashboard" /> Participation et dépouillement en direct</li>
            <li><x-icon name="users" /> Gestion des électeurs et des listes</li>
            <li><x-icon name="lock" /> Session dédiée, protégée et journalisée</li>
        </ul>
    </aside>

    <section class="card auth-form reveal" data-i="1">
        <span class="surtitre"><x-icon name="lock" /> Espace administrateur</span>
        <h1 class="titre-l">Administration</h1>
        <p class="doux">Connectez-vous pour démarrer votre session.</p>

        <form method="POST" action="{{ route('admin.login') }}" class="champs" data-envoi>
            @csrf
            @if ($errors->any())
                <div class="alerte alerte-erreur" role="alert"><x-icon name="alert" /> <span>{{ $errors->first() }}</span></div>
            @endif

            <div class="champ">
                <label for="email">Adresse e-mail</label>
                <div class="champ-controle">
                    <x-icon name="mail" />
                    <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="username" maxlength="255" required autofocus>
                </div>
            </div>
            <div class="champ">
                <label for="password">Mot de passe</label>
                <div class="champ-controle">
                    <x-icon name="lock" />
                    <input type="password" id="password" name="password" autocomplete="current-password" maxlength="255" required>
                    <button type="button" class="champ-oeil" data-oeil aria-label="Afficher ou masquer le mot de passe">
                        <x-icon name="eye" class="icon-oeil" /><x-icon name="eye-off" class="icon-oeil-barre" />
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg btn-block">Ouvrir la session <x-icon name="arrow-right" class="icon-fleche" /></button>
        </form>

        <p class="auth-bas">Vous êtes étudiant ? <a class="lien" href="{{ route('login') }}">Espace étudiant</a></p>
    </section>
</div>
@endsection
