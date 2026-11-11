@extends('layouts.admin')
@section('titre', 'Scrutins')

@section('contenu')
<p class="doux reveal">Définissez la période de vote de chaque UFR. Les votes ne sont acceptés qu'entre la date d'ouverture et la date de clôture (incluses).</p>

<div class="scrutins">
    @foreach ($ufrs as $i => $ufr)
        @php($scrutin = $ufr->scrutin)
        <section class="card card-pad scrutin reveal" data-i="{{ $i % 3 }}">
            <div class="rangee entre">
                <h2 class="titre-m">UFR {{ $ufr->sigle }}</h2>
                @if (! $scrutin)
                    <span class="pill pill-alerte">Non programmé</span>
                @elseif ($scrutin->statut === 'ouvert')
                    <span class="pill pill-ok"><span class="point point-vif"></span> Ouvert</span>
                @elseif ($scrutin->statut === 'a_venir')
                    <span class="pill pill-accent"><x-icon name="calendar" /> À venir</span>
                @else
                    <span class="pill pill-alerte"><x-icon name="lock" /> Clos</span>
                @endif
            </div>
            <div class="liste-meta">
                <span><x-icon name="users" /> {{ $ufr->etudiants_count }} inscrit(s)</span>
                <span><x-icon name="list" /> {{ $ufr->listes_count }} liste(s)</span>
            </div>
            <form method="POST" action="{{ route('majScrutin', $ufr->id_ufr) }}" data-envoi>
                @csrf
                @method('PUT')
                <div class="champs-2">
                    <div class="champ">
                        <label for="debut-{{ $ufr->id_ufr }}">Ouverture</label>
                        <input class="sans-icone" type="date" id="debut-{{ $ufr->id_ufr }}" name="date_debut" value="{{ $scrutin?->date_debut->toDateString() }}" required>
                    </div>
                    <div class="champ">
                        <label for="fin-{{ $ufr->id_ufr }}">Clôture</label>
                        <input class="sans-icone" type="date" id="fin-{{ $ufr->id_ufr }}" name="date_fin" value="{{ $scrutin?->date_fin->toDateString() }}" required>
                    </div>
                </div>
                <label class="case">
                    <input type="checkbox" name="resultats_en_direct" value="1" @checked($scrutin?->resultats_en_direct ?? true)>
                    <span>Résultats visibles en direct par les étudiants <span class="doux petit">(sinon dévoilés à la clôture ; la participation reste visible)</span></span>
                </label>
                <button type="submit" class="btn btn-block"><x-icon name="check" /> Enregistrer</button>
            </form>
            @if ($scrutin)
                <a class="btn btn-ghost btn-block" href="{{ route('admin.pv', $ufr->id_ufr) }}"><x-icon name="printer" /> Procès-verbal</a>
            @endif
        </section>
    @endforeach
</div>
@endsection
