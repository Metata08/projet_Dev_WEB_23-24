{{-- Pastille d'état du scrutin + compte à rebours --}}
@if (! $scrutin)
    <span class="pill pill-alerte"><x-icon name="alert" /> Aucun scrutin programmé pour votre UFR</span>
@elseif ($scrutin->statut === 'ouvert')
    <span class="pill pill-ok"><span class="point point-vif"></span> Scrutin ouvert jusqu'au {{ $scrutin->date_fin->format('d/m/Y') }}</span>
@elseif ($scrutin->statut === 'a_venir')
    <span class="pill pill-accent"><x-icon name="calendar" /> Ouverture le {{ $scrutin->date_debut->format('d/m/Y') }}</span>
@else
    <span class="pill pill-alerte"><x-icon name="lock" /> Scrutin clos depuis le {{ $scrutin->date_fin->format('d/m/Y') }}</span>
@endif
