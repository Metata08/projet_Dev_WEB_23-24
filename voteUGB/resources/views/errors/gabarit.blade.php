@extends('layouts.app')
@section('titre', $titre)

@section('contenu')
<div class="container erreur">
    <div>
        <p class="erreur-code texte-degrade">{{ $code }}</p>
        <h1 class="titre-l">{{ $titre }}</h1>
        <p class="chapo">{{ $texte }}</p>
        <p><a class="btn btn-primary btn-lg" href="{{ route('ugbvote') }}"><x-icon name="home" /> Retour à l'accueil</a></p>
    </div>
</div>
@endsection
