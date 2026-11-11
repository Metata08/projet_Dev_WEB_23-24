@extends('layouts.app')
@section('titre', 'Confirmer mon vote')

@section('contenu')
<div class="container-etroit section-serree">
    <a class="fil reveal" href="{{ route('election') }}"><x-icon name="arrow-left" /> Retour aux listes</a>

    <article class="card bulletin-carte reveal" data-i="1">
        <header class="bulletin-tete">
            <span class="surtitre"><x-icon name="vote" /> Bulletin de vote</span>
            <h1>{{ $liste->name_list }}</h1>
        </header>

        <div class="bulletin-corps">
            <div class="bulletin-infos">
                <div><span>UFR</span><strong>{{ $liste->ufr?->sigle }}</strong></div>
                @if ($teteDeListe)<div><span>Tête de liste</span><strong>{{ $teteDeListe->prenom }} {{ $teteDeListe->nom }}</strong></div>@endif
                @if ($scrutin)<div><span>Clôture</span><strong>{{ $scrutin->date_fin->format('d/m/Y') }}</strong></div>@endif
            </div>

            @if ($bulletin)
                <div class="alerte alerte-succes"><x-icon name="check-circle" /> <span>Vous avez déjà voté le {{ $bulletin->voted_at->format('d/m/Y à H:i') }}. Un seul vote est autorisé par étudiant.</span></div>
                <a class="btn btn-primary btn-block" href="{{ route('resultat') }}"><x-icon name="chart" /> Voir les résultats</a>
            @elseif (! $scrutin || ! $scrutin->estOuvert())
                <div class="alerte alerte-erreur"><x-icon name="lock" /> <span>Le scrutin de votre UFR n'est pas ouvert : le vote est impossible pour le moment.</span></div>
                <a class="btn btn-block" href="{{ route('election') }}">Retour aux listes</a>
            @else
                <div class="alerte"><x-icon name="alert" /> <span><strong>Votre vote est définitif.</strong> Une fois confirmé, il ne pourra être ni modifié ni annulé.</span></div>

                <form method="POST" action="{{ route('systemevote.vote', ['id' => $liste->id_list]) }}" class="stack" data-envoi>
                    @csrf
                    @error('confirmation')<div class="alerte alerte-erreur" role="alert"><x-icon name="alert" /> <span>{{ $message }}</span></div>@enderror
                    <label class="case">
                        <input type="checkbox" name="confirmation" value="1" data-active="#confirmer" required>
                        <span>Je confirme voter pour la liste <strong>« {{ $liste->name_list }} »</strong>.</span>
                    </label>
                    <div class="bulletin-actions">
                        <a class="btn btn-lg" href="{{ route('election') }}">Annuler</a>
                        <button type="submit" id="confirmer" class="btn btn-primary btn-lg" disabled>Confirmer mon vote <x-icon name="check" /></button>
                    </div>
                </form>
            @endif
        </div>
    </article>
</div>
@endsection
