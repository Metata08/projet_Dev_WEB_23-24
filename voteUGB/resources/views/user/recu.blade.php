@extends('layouts.app')
@section('titre', 'Vérifier mon reçu')

@section('contenu')
<div class="container-etroit section-serree">
    <a class="fil reveal" href="{{ route('resultat') }}"><x-icon name="arrow-left" /> Résultats</a>

    <section class="card card-pad stack reveal" data-i="1">
        <span class="surtitre"><x-icon name="shield" /> Reçu de vote</span>
        <h1 class="titre-l">Mon bulletin est-il dans l'urne ?</h1>
        <p class="doux">Saisissez le reçu affiché juste après votre vote. La vérification confirme la présence du bulletin, <strong>jamais la liste choisie</strong> : personne ne peut vous demander de prouver votre vote.</p>

        @if ($verdict === 'present')
            <div class="alerte alerte-succes" role="status"><x-icon name="check-circle" /> <span><strong>Bulletin trouvé.</strong> Le bulletin associé à ce reçu est bien dans l'urne et sera compté.</span></div>
        @elseif ($verdict === 'absent')
            <div class="alerte alerte-erreur" role="alert"><x-icon name="alert" /> <span><strong>Aucun bulletin ne correspond à ce reçu.</strong> Vérifiez la saisie ; si le problème persiste, contactez l'administration.</span></div>
        @endif

        <form method="POST" action="{{ route('recu.verifier') }}" class="champs" data-envoi>
            @csrf
            <div class="champ @error('recu') invalide @enderror">
                <label for="recu">Reçu de vote</label>
                <div class="champ-controle">
                    <x-icon name="shield" />
                    <input class="mono" type="text" id="recu" name="recu" value="{{ $saisi ?? '' }}" placeholder="UGB-XXXX-XXXX-XXXX" maxlength="40" autocomplete="off" autocapitalize="characters" spellcheck="false" required>
                </div>
                <span class="champ-erreur">@error('recu'){{ $message }}@enderror</span>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Vérifier <x-icon name="arrow-right" class="icon-fleche" /></button>
        </form>
    </section>
</div>
@endsection
