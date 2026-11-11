@extends('layouts.app')
@section('titre', 'Ma liste')

@section('contenu')
<div class="container">
    <header class="page-tete">
        <div class="reveal">
            <span class="surtitre"><x-icon name="sparkles" /> Espace candidat</span>
            <h1 class="titre-l">Ma page de <span class="texte-degrade">campagne</span></h1>
            <p class="chapo">Liste « {{ $liste->name_list }} ». Chaque modification est relue par l'administration avant d'être publiée.</p>
            <div class="rangee">
                @if ($liste->campagne_validee)
                    <span class="pill pill-ok"><x-icon name="check" /> Page publiée</span>
                @else
                    <span class="pill pill-alerte"><x-icon name="clock" /> En attente de validation</span>
                @endif
                <a class="btn btn-sm" href="{{ route('detailListe', $liste->id_list) }}"><x-icon name="eye" /> Aperçu</a>
            </div>
        </div>
    </header>

    @if ($errors->any())
        <div class="alerte alerte-erreur reveal" role="alert"><x-icon name="alert" /> <span>{{ $errors->first() }}</span></div>
    @endif
    @unless ($modifiable)
        <div class="alerte reveal"><x-icon name="lock" /> <span>Le scrutin est clos : la page de campagne ne peut plus être modifiée.</span></div>
    @endunless

    <fieldset class="edition" @disabled(! $modifiable)>
        <legend class="sr-only">Édition de la page de campagne</legend>

        <section class="card card-pad reveal">
            <h2 class="titre-m">Présentation</h2>
            <form method="POST" action="{{ route('maListe.infos') }}" enctype="multipart/form-data" class="champs" data-envoi>
                @csrf
                @method('PUT')
                <div class="champs-2">
                    <div class="champ">
                        <label for="slogan">Slogan</label>
                        <input class="sans-icone" type="text" id="slogan" name="slogan" value="{{ old('slogan', $liste->slogan) }}" maxlength="160" placeholder="Une phrase qui vous résume">
                    </div>
                    <div class="champ">
                        <label for="titre">Titre du programme</label>
                        <input class="sans-icone" type="text" id="titre" name="titre" value="{{ old('titre', $liste->titre) }}" maxlength="120" placeholder="Notre projet">
                    </div>
                </div>
                <div class="champ">
                    <label for="programme">Présentation de la liste</label>
                    <textarea id="programme" name="programme" maxlength="10000" required>{{ old('programme', $liste->programme) }}</textarea>
                </div>
                <div class="champ">
                    <label for="logo">Logo <span class="doux">(JPG, PNG ou WebP, 1 Mo maximum)</span></label>
                    <div class="logo-edition">
                        @include('partials.sigle', ['liste' => $liste, 'afficherBrouillon' => true])
                        <input class="sans-icone" type="file" id="logo" name="logo" accept="image/jpeg,image/png,image/webp">
                    </div>
                </div>
                <div><button type="submit" class="btn btn-primary"><x-icon name="check" /> Enregistrer la présentation</button></div>
            </form>
        </section>

        <div class="edition-colonnes">
            <section class="card card-pad reveal">
                <h2 class="titre-m">Propositions <span class="doux petit">({{ $propositions->count() }})</span></h2>
                <p class="doux petit">Classées par thème pour être comparables d'une liste à l'autre.</p>
                <ul class="edition-liste">
                    @forelse ($propositions as $proposition)
                        <li>
                            <div><span class="pill pill-accent">{{ $proposition->theme_libelle }}</span><p>{{ $proposition->texte }}</p></div>
                            <form method="POST" action="{{ route('maListe.proposition.supprimer', $proposition->id) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-icon btn-sm" aria-label="Supprimer la proposition"><x-icon name="trash" /></button>
                            </form>
                        </li>
                    @empty
                        <li class="doux petit">Aucune proposition pour l'instant.</li>
                    @endforelse
                </ul>
                <form method="POST" action="{{ route('maListe.proposition') }}" class="champs" data-envoi>
                    @csrf
                    <div class="champ">
                        <label for="theme">Thème</label>
                        <div class="champ-controle">
                            <select class="sans-icone" id="theme" name="theme" required>
                                @foreach ($themes as $cle => $libelle)
                                    <option value="{{ $cle }}" @selected(old('theme') === $cle)>{{ $libelle }}</option>
                                @endforeach
                            </select>
                            <x-icon name="chevron-down" class="champ-chevron" />
                        </div>
                    </div>
                    <div class="champ">
                        <label for="texte">Proposition</label>
                        <input class="sans-icone" type="text" id="texte" name="texte" value="{{ old('texte') }}" maxlength="400" required placeholder="Une mesure concrète, en une phrase">
                    </div>
                    <div><button type="submit" class="btn"><x-icon name="plus" /> Ajouter la proposition</button></div>
                </form>
            </section>

            <section class="card card-pad reveal" data-i="1">
                <h2 class="titre-m">Bilan et réalisations <span class="doux petit">({{ $realisations->count() }})</span></h2>
                <p class="doux petit">Ce que votre équipe a déjà accompli : restez factuel et vérifiable.</p>
                <ul class="edition-liste">
                    @forelse ($realisations as $realisation)
                        <li>
                            <div>@if ($realisation->annee)<span class="pill pill-accent">{{ $realisation->annee }}</span>@endif<p><strong>{{ $realisation->titre }}</strong>@if ($realisation->description) — {{ $realisation->description }}@endif</p></div>
                            <form method="POST" action="{{ route('maListe.realisation.supprimer', $realisation->id) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-icon btn-sm" aria-label="Supprimer la réalisation"><x-icon name="trash" /></button>
                            </form>
                        </li>
                    @empty
                        <li class="doux petit">Aucune réalisation pour l'instant.</li>
                    @endforelse
                </ul>
                <form method="POST" action="{{ route('maListe.realisation') }}" class="champs" data-envoi>
                    @csrf
                    <div class="champs-2">
                        <div class="champ">
                            <label for="annee">Année</label>
                            <input class="sans-icone" type="text" id="annee" name="annee" value="{{ old('annee') }}" maxlength="9" placeholder="2025-2026">
                        </div>
                        <div class="champ">
                            <label for="titre-real">Titre</label>
                            <input class="sans-icone" type="text" id="titre-real" name="titre" value="{{ old('titre') }}" maxlength="150" required>
                        </div>
                    </div>
                    <div class="champ">
                        <label for="description">Description</label>
                        <input class="sans-icone" type="text" id="description" name="description" value="{{ old('description') }}" maxlength="600">
                    </div>
                    <div><button type="submit" class="btn"><x-icon name="plus" /> Ajouter la réalisation</button></div>
                </form>
            </section>
        </div>
    </fieldset>
</div>
@endsection
