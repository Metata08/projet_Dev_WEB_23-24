@extends('layouts.admin')
@section('titre', 'Procès-verbal')

@section('actions')
    <a class="btn btn-sm bureau-seul" href="{{ route('listePostes') }}"><x-icon name="arrow-left" /> Scrutins</a>
    <button type="button" class="btn btn-primary btn-sm" data-imprimer><x-icon name="printer" /> <span class="bureau-seul">Imprimer / PDF</span></button>
@endsection

@section('contenu')
@php($exprimes = array_sum(array_column($donnees['resultats'], 'votes')))
<article class="card card-pad pv">
    <header class="centre">
        <img class="pv-logo" src="{{ asset('images/logo.png') }}" alt="UGB Vote" width="401" height="142">
        <p class="surtitre">Université Gaston Berger de Saint-Louis</p>
        <h2 class="titre-l">Procès-verbal de dépouillement</h2>
        <p class="doux">Élection du représentant des étudiants — UFR {{ $ufr->sigle }}</p>
    </header>

    @if (! $scrutin)
        <div class="alerte alerte-erreur"><x-icon name="alert" /> <span>Aucun scrutin n'est programmé pour cette UFR.</span></div>
    @else
        @if ($scrutin->statut !== 'clos')
            <div class="alerte alerte-erreur sans-impression"><x-icon name="alert" /> <span><strong>Résultats provisoires :</strong> le scrutin n'est pas clos. Ce document n'a de valeur qu'après la clôture.</span></div>
        @endif

        <dl class="pv-infos">
            <div><dt>Période du scrutin</dt><dd>du {{ $scrutin->date_debut->format('d/m/Y') }} au {{ $scrutin->date_fin->format('d/m/Y') }}</dd></div>
            <div><dt>État</dt><dd>{{ ['a_venir' => 'À venir', 'ouvert' => 'En cours (provisoire)', 'clos' => 'Clos (définitif)'][$scrutin->statut] }}</dd></div>
            <div><dt>Électeurs inscrits</dt><dd>{{ $donnees['inscrits'] }}</dd></div>
            <div><dt>Votants (émargements)</dt><dd>{{ $donnees['votants'] }}</dd></div>
            <div><dt>Bulletins dans l'urne</dt><dd>{{ $exprimes }}</dd></div>
            <div><dt>Participation</dt><dd>{{ number_format($donnees['participation'], 1, ',', ' ') }} %</dd></div>
        </dl>

        <div class="table-zone">
            <table class="table pv-table">
                <thead><tr><th>Rang</th><th>Liste</th><th class="droite">Voix</th><th class="droite">% des exprimés</th></tr></thead>
                <tbody>
                    @forelse ($donnees['resultats'] as $i => $ligne)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><strong>{{ $ligne['liste'] }}</strong></td>
                            <td class="droite">{{ $ligne['votes'] }}</td>
                            <td class="droite">{{ number_format($ligne['pourcentage'], 1, ',', ' ') }} %</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="doux">Aucune liste candidate.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($donnees['votants'] !== $exprimes)
            <p class="doux petit">Écart entre émargements ({{ $donnees['votants'] }}) et bulletins ({{ $exprimes }}) : il s'explique par la suppression d'un électeur ou d'une liste en cours de scrutin (voir le journal d'administration).</p>
        @endif

        <footer class="pv-signatures">
            <div><span>Le président du bureau de vote</span></div>
            <div><span>Le représentant de l'administration</span></div>
        </footer>
        <p class="doux petit centre">Document édité le {{ now()->format('d/m/Y à H:i') }} par {{ auth('admin')->user()->name }} — UGB Vote</p>
    @endif
</article>
@endsection
