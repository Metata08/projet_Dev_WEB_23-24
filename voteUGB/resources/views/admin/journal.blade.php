@extends('layouts.admin')
@section('titre', 'Journal')

@section('contenu')
<section class="card reveal">
    <div class="card-pad rangee entre">
        <div>
            <h2 class="titre-m">Journal des actions</h2>
            <p class="doux petit">Les 300 dernières actions d'administration. Le journal ne peut pas être modifié depuis l'interface.</p>
        </div>
        <label class="recherche">
            <span class="sr-only">Rechercher dans le journal</span>
            <x-icon name="search" />
            <input type="search" placeholder="Rechercher…" data-filtre="#table-journal">
        </label>
    </div>
    @if ($entrees->isEmpty())
        <div class="vide"><span class="pastille-icone"><x-icon name="clock" /></span><h3 class="titre-m">Journal vide</h3><p>Aucune action enregistrée pour l'instant.</p></div>
    @else
        <div class="table-zone">
            <table class="table" id="table-journal">
                <thead><tr><th>Date</th><th>Administrateur</th><th>Action</th><th>Détails</th><th>Adresse IP</th></tr></thead>
                <tbody>
                    @foreach ($entrees as $entree)
                        <tr>
                            <td class="principal"><span class="mono">{{ $entree->created_at->format('d/m/Y H:i:s') }}</span></td>
                            <td data-titre="Administrateur">{{ $entree->admin_nom ?? '—' }}</td>
                            <td data-titre="Action"><span class="pill pill-accent">{{ $entree->action }}</span></td>
                            <td data-titre="Détails"><span class="doux">{{ $entree->details ?? '—' }}</span></td>
                            <td data-titre="IP"><span class="mono">{{ $entree->ip }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p class="vide doux" data-aucun hidden>Aucun résultat pour cette recherche.</p>
        </div>
    @endif
</section>
@endsection
