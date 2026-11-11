@extends('layouts.app')
@section('titre', 'Connexion')

@section('contenu')
<div class="container auth">
    <aside class="auth-visuel reveal">
        <div>
            <span class="pill"><span class="point point-vif"></span> Scrutin en ligne</span>
            <h2>Heureux de vous revoir.</h2>
            <p>Connectez-vous pour découvrir les listes de votre UFR et faire entendre votre voix.</p>
        </div>
        <ul class="auth-points">
            <li><x-icon name="shield" /> Connexion protégée contre les attaques par force brute</li>
            <li><x-icon name="lock" /> Mots de passe chiffrés, jamais stockés en clair</li>
            <li><x-icon name="zap" /> Résultats disponibles en temps réel</li>
        </ul>
    </aside>

    <section class="card auth-form reveal" data-i="1">
        <span class="surtitre"><x-icon name="log-in" /> Espace étudiant</span>
        <h1 class="titre-l">Connexion</h1>
        <p class="doux">Entrez vos identifiants pour accéder au vote.</p>

        <form method="POST" action="{{ route('login.post') }}" class="champs" data-envoi>
            @csrf
            @if ($errors->any())
                <div class="alerte alerte-erreur" role="alert"><x-icon name="alert" /> <span>{{ $errors->first() }}</span></div>
            @endif

            <div class="champ">
                <label for="email">Adresse e-mail</label>
                <div class="champ-controle">
                    <x-icon name="mail" />
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="etudiant@ugb.edu.sn" autocomplete="email" maxlength="255" required autofocus>
                </div>
            </div>

            <div class="champ">
                <label for="password">Mot de passe</label>
                <div class="champ-controle">
                    <x-icon name="lock" />
                    <input type="password" id="password" name="password" placeholder="Votre mot de passe" autocomplete="current-password" maxlength="255" required>
                    <button type="button" class="champ-oeil" data-oeil aria-label="Afficher ou masquer le mot de passe">
                        <x-icon name="eye" class="icon-oeil" /><x-icon name="eye-off" class="icon-oeil-barre" />
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg btn-block">Se connecter <x-icon name="arrow-right" class="icon-fleche" /></button>
        </form>

        <p class="auth-bas"><a class="lien" href="{{ route('password.request') }}">Mot de passe oublié ?</a></p>
        <p class="auth-bas">Vous n'avez pas de compte ? <a class="lien" href="{{ route('inscription') }}">Inscrivez-vous</a></p>
    </section>
</div>
@endsection
