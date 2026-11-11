@extends('layouts.app')
@section('titre', 'Inscription')

@section('contenu')
<div class="container auth">
    <aside class="auth-visuel reveal">
        <div>
            <span class="pill"><span class="point point-vif"></span> Inscriptions ouvertes</span>
            <h2>Rejoignez le scrutin en deux minutes.</h2>
            <p>Munissez-vous de votre code étudiant officiel : il garantit que seuls les étudiants de l'UGB peuvent voter.</p>
        </div>
        <ul class="auth-points">
            <li><x-icon name="id" /> Code étudiant vérifié auprès de l'université</li>
            <li><x-icon name="building" /> Vous votez pour les listes de votre UFR</li>
            <li><x-icon name="shield" /> Un compte, un vote : pas de doublon possible</li>
        </ul>
    </aside>

    <section class="card auth-form reveal" data-i="1">
        <span class="surtitre"><x-icon name="user" /> Nouveau compte</span>
        <h1 class="titre-l">Inscription</h1>
        <p class="doux">Tous les champs sont obligatoires.</p>

        <form method="POST" action="{{ route('inscription.register') }}" class="champs" data-envoi data-validation novalidate>
            @csrf

            <div class="champs-2">
                <div class="champ @error('prenom') invalide @enderror">
                    <label for="prenom">Prénom</label>
                    <div class="champ-controle">
                        <x-icon name="user" />
                        <input type="text" id="prenom" name="prenom" value="{{ old('prenom') }}" autocomplete="given-name" maxlength="100" required data-regle="nom">
                    </div>
                    <span class="champ-erreur" data-erreur>@error('prenom'){{ $message }}@enderror</span>
                </div>
                <div class="champ @error('nom') invalide @enderror">
                    <label for="nom">Nom</label>
                    <div class="champ-controle">
                        <x-icon name="user" />
                        <input type="text" id="nom" name="nom" value="{{ old('nom') }}" autocomplete="family-name" maxlength="100" required data-regle="nom">
                    </div>
                    <span class="champ-erreur" data-erreur>@error('nom'){{ $message }}@enderror</span>
                </div>
            </div>

            <div class="champs-2">
                <div class="champ @error('code') invalide @enderror">
                    <label for="code">Code étudiant</label>
                    <div class="champ-controle">
                        <x-icon name="id" />
                        <input type="text" id="code" name="code" value="{{ old('code') }}" placeholder="p31 0000" maxlength="50" autocomplete="off" required>
                    </div>
                    <span class="champ-erreur" data-erreur>@error('code'){{ $message }}@enderror</span>
                </div>
                <div class="champ @error('ufr') invalide @enderror">
                    <label for="ufr">UFR</label>
                    <div class="champ-controle">
                        <x-icon name="building" />
                        <select id="ufr" name="ufr" required>
                            <option value="">Sélectionnez votre UFR</option>
                            @foreach ($ufrs as $ufr)
                                <option value="{{ $ufr->id_ufr }}" @selected(old('ufr') == $ufr->id_ufr)>{{ $ufr->sigle }}</option>
                            @endforeach
                        </select>
                        <x-icon name="chevron-down" class="champ-chevron" />
                    </div>
                    <span class="champ-erreur" data-erreur>@error('ufr'){{ $message }}@enderror</span>
                </div>
            </div>

            <div class="champ @error('email') invalide @enderror">
                <label for="email">Adresse e-mail</label>
                <div class="champ-controle">
                    <x-icon name="mail" />
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="etudiant@ugb.edu.sn" autocomplete="email" maxlength="255" required data-regle="email">
                </div>
                <span class="champ-erreur" data-erreur>@error('email'){{ $message }}@enderror</span>
            </div>

            <div class="champs-2">
                <div class="champ @error('password') invalide @enderror">
                    <label for="password">Mot de passe</label>
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
            </div>

            <button type="submit" class="btn btn-primary btn-lg btn-block">Créer mon compte <x-icon name="arrow-right" class="icon-fleche" /></button>
        </form>

        <p class="auth-bas">Vous avez déjà un compte ? <a class="lien" href="{{ route('login') }}">Connectez-vous</a></p>
    </section>
</div>
@endsection
