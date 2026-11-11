@extends('layouts.app')
@section('titre', 'Nouveau mot de passe')

@section('contenu')
<div class="container-etroit section-serree">
    <section class="card auth-form reveal">
        <span class="surtitre"><x-icon name="lock" /> Espace étudiant</span>
        <h1 class="titre-l">Nouveau mot de passe</h1>

        <form method="POST" action="{{ route('password.update') }}" class="champs" data-envoi data-validation novalidate>
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            @error('email')<div class="alerte alerte-erreur" role="alert"><x-icon name="alert" /> <span>{{ $message }}</span></div>@enderror

            <div class="champ">
                <label for="email">Adresse e-mail</label>
                <div class="champ-controle">
                    <x-icon name="mail" />
                    <input type="email" id="email" name="email" value="{{ old('email', $email) }}" autocomplete="email" maxlength="255" required data-regle="email">
                </div>
                <span class="champ-erreur" data-erreur></span>
            </div>
            <div class="champ @error('password') invalide @enderror">
                <label for="password">Nouveau mot de passe</label>
                <div class="champ-controle">
                    <x-icon name="lock" />
                    <input type="password" id="password" name="password" autocomplete="new-password" minlength="8" maxlength="255" required data-regle="motdepasse" data-force="#force">
                    <button type="button" class="champ-oeil" data-oeil aria-label="Afficher ou masquer le mot de passe">
                        <x-icon name="eye" class="icon-oeil" /><x-icon name="eye-off" class="icon-oeil-barre" />
                    </button>
                </div>
                <div class="force" id="force" data-niveau="0" aria-hidden="true"><i></i><i></i><i></i><i></i></div>
                <span class="champ-erreur" data-erreur>@error('password'){{ $message }}@enderror</span>
                <span class="champ-aide">8 caractères minimum, avec des lettres et des chiffres.</span>
            </div>
            <div class="champ">
                <label for="password_confirmation">Confirmation</label>
                <div class="champ-controle">
                    <x-icon name="lock" />
                    <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" maxlength="255" required data-regle="confirmation" data-miroir="#password">
                </div>
                <span class="champ-erreur" data-erreur></span>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Enregistrer <x-icon name="check" /></button>
        </form>
    </section>
</div>
@endsection
