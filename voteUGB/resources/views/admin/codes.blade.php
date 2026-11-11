@extends('layouts.admin')
@section('titre', 'Codes étudiants')

@section('contenu')
<p class="doux reveal">Seuls les étudiants dont le code figure ici peuvent créer un compte. Chaque code ne sert qu'une fois.</p>

<div class="detail">
    <section class="card reveal">
        <div class="card-pad rangee entre">
            <h2 class="titre-m">{{ $codes->count() }} code(s) · {{ $codes->whereNotNull('compte')->count() }} utilisé(s)</h2>
            <label class="recherche">
                <span class="sr-only">Rechercher un code</span>
                <x-icon name="search" />
                <input type="search" placeholder="Rechercher un code ou un e-mail…" data-filtre="#table-codes">
            </label>
        </div>
        <div class="table-zone">
            <table class="table" id="table-codes">
                <thead><tr><th>Code</th><th>Compte associé</th><th class="droite">Action</th></tr></thead>
                <tbody>
                    @foreach ($codes as $code)
                        <tr>
                            <td class="principal"><span class="mono">{{ $code['code'] }}</span></td>
                            <td data-titre="Compte">
                                @if ($code['compte'])
                                    <span class="pill pill-ok"><x-icon name="check" /> {{ $code['compte'] }}</span>
                                @else
                                    <span class="pill">Libre</span>
                                @endif
                            </td>
                            <td data-titre="Action" class="droite">
                                @if (! $code['compte'])
                                    <form method="POST" action="{{ route('admin.codes.supprimer', $code['id']) }}" data-confirm="Supprimer le code {{ $code['code'] }} ? L'étudiant ne pourra plus s'inscrire." data-confirm-titre="Supprimer le code" data-confirm-action="Supprimer" data-confirm-danger>
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><x-icon name="trash" /> Supprimer</button>
                                    </form>
                                @else
                                    <span class="doux petit">Code utilisé</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p class="vide doux" data-aucun hidden>Aucun résultat pour cette recherche.</p>
        </div>
    </section>

    <aside class="stack">
        <section class="card card-pad reveal" data-i="1">
            <h2 class="titre-s">Importer un fichier</h2>
            <p class="doux petit">Fichier CSV ou texte, un code par ligne (ou séparés par des virgules ou points-virgules). Les doublons sont ignorés.</p>
            <form method="POST" action="{{ route('admin.codes.importer') }}" enctype="multipart/form-data" class="champs" data-envoi>
                @csrf
                <div class="champ">
                    <label for="fichier">Fichier <span class="doux">(.csv ou .txt, 1 Mo maximum)</span></label>
                    <input class="sans-icone" type="file" id="fichier" name="fichier" accept=".csv,.txt,text/csv,text/plain" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block"><x-icon name="plus" /> Importer</button>
            </form>
        </section>
        <section class="card card-pad reveal" data-i="2">
            <h2 class="titre-s">Ajouter un code</h2>
            <form method="POST" action="{{ route('admin.codes.importer') }}" class="champs" data-envoi>
                @csrf
                <div class="champ">
                    <label for="code">Code étudiant</label>
                    <input class="sans-icone mono" type="text" id="code" name="code" maxlength="50" placeholder="p31 0000" required>
                </div>
                <button type="submit" class="btn btn-block"><x-icon name="plus" /> Ajouter</button>
            </form>
        </section>
    </aside>
</div>
@endsection
