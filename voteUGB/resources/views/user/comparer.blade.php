@extends('layouts.app')
@section('titre', 'Comparer les programmes')

@section('contenu')
<div class="container">
    <header class="page-tete">
        <div class="reveal">
            <a class="fil" href="{{ route('election') }}"><x-icon name="arrow-left" /> Toutes les listes</a>
            <span class="surtitre"><x-icon name="list" /> Comparateur</span>
            <h1 class="titre-l">Les programmes, <span class="texte-degrade">thème par thème</span></h1>
            <p class="chapo">Les propositions de chaque liste de votre UFR, côte à côte, pour choisir en connaissance de cause.</p>
        </div>
    </header>

    @if ($listes->isEmpty())
        <div class="card vide reveal"><span class="pastille-icone"><x-icon name="list" /></span><h2 class="titre-m">Rien à comparer pour l'instant</h2><p>Aucune page de campagne n'est encore publiée pour votre UFR.</p></div>
    @else
        <div class="card comparateur-zone reveal" tabindex="0" role="region" aria-label="Tableau comparatif des programmes">
            <table class="comparateur">
                <thead>
                    <tr>
                        <th scope="col">Thème</th>
                        @foreach ($listes as $liste)
                            <th scope="col"><a class="lien" href="{{ route('detailListe', $liste->id_list) }}">{{ $liste->name_list }}</a></th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($themes as $cle => $libelle)
                        <tr>
                            <th scope="row">{{ $libelle }}</th>
                            @foreach ($listes as $liste)
                                @php($lignes = $liste->propositions->where('theme', $cle))
                                <td>
                                    @forelse ($lignes as $proposition)
                                        <p><x-icon name="check-circle" /> <span>{{ $proposition->texte }}</span></p>
                                    @empty
                                        <span class="doux petit">Aucune proposition</span>
                                    @endforelse
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
