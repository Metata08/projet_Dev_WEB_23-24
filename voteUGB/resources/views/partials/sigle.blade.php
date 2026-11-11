{{-- Logo de la liste s'il est publié, sinon son initiale --}}
@if ($liste->logo && ($liste->campagne_validee || ($afficherBrouillon ?? false)))
    <span class="liste-sigle liste-logo"><img src="{{ route('liste.logo', $liste->id_list) }}?v={{ $liste->updated_at?->timestamp }}" alt="Logo de la liste {{ $liste->name_list }}" loading="lazy"></span>
@else
    <span class="liste-sigle" aria-hidden="true">{{ $liste->sigle }}</span>
@endif
