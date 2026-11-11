@extends('layouts.app')
@section('titre', 'Mot de passe oublié')

@section('contenu')
<div class="container-etroit section-serree">
    <section class="card auth-form reveal">
        <span class="surtitre"><x-icon name="lock" /> Espace étudiant</span>
        <h1 class="titre-l">Mot de passe oublié</h1>
        <p class="doux">Indiquez l'adresse e-mail de votre compte : nous vous enverrons un lien pour choisir un nouveau mot de passe.</p>

        <form method="POST" action="{{ route('password.email') }}" class="champs" data-envoi>
            @csrf
            @if (session('success'))
                <div class="alerte alerte-succes" role="status"><x-icon name="check-circle" /> <span>{{ session('success') }}</span></div>
            @endif
            <div class="champ @error('email') invalide @enderror">
                <label for="email">Adresse e-mail</label>
                <div class="champ-controle">
                    <x-icon name="mail" />
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="etudiant@ugb.edu.sn" autocomplete="email" maxlength="255" required autofocus>
                </div>
                <span class="champ-erreur">@error('email'){{ $message }}@enderror</span>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Recevoir le lien <x-icon name="arrow-right" class="icon-fleche" /></button>
        </form>

        <p class="auth-bas"><a class="lien" href="{{ route('login') }}">Retour à la connexion</a></p>
    </section>
</div>
@endsection
