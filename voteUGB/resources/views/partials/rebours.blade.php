@if ($scrutin && $scrutin->statut !== 'clos')
    <div>
        <p class="petit doux">{{ $scrutin->statut === 'ouvert' ? 'Clôture du scrutin dans' : 'Ouverture du scrutin dans' }}</p>
        <div class="rebours" data-rebours="{{ $scrutin->echeance->toIso8601String() }}" role="timer" aria-label="Compte à rebours">
            <div><strong data-j>--</strong><span>jours</span></div>
            <div><strong data-h>--</strong><span>heures</span></div>
            <div><strong data-m>--</strong><span>min</span></div>
            <div><strong data-s>--</strong><span>sec</span></div>
        </div>
    </div>
@endif
