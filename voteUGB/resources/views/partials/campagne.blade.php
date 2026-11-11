{{-- Contenu d'une page de campagne : présentation, propositions par thème, bilan --}}
<section class="card card-pad reveal">
    <h2 class="titre-m">{{ $liste->titre ?: 'Notre projet' }}</h2>
    <p class="programme-texte">{{ $liste->programme }}</p>
</section>

@if ($propositions->isNotEmpty())
    <section class="card card-pad reveal">
        <h2 class="titre-m">Nos propositions</h2>
        <div class="themes">
            @foreach ($themes as $cle => $libelle)
                @continue(! $propositions->has($cle))
                <div class="theme">
                    <h3 class="surtitre">{{ $libelle }}</h3>
                    <ul class="programme-points">
                        @foreach ($propositions[$cle] as $proposition)
                            <li><x-icon name="check-circle" /> <span>{{ $proposition->texte }}</span></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </section>
@endif

@if ($realisations->isNotEmpty())
    <section class="card card-pad reveal">
        <h2 class="titre-m">Bilan et réalisations</h2>
        <p class="doux petit">Actions déjà menées par l'équipe, déclarées par la liste.</p>
        <ol class="frise">
            @foreach ($realisations as $realisation)
                <li>
                    @if ($realisation->annee)<span class="pill pill-accent">{{ $realisation->annee }}</span>@endif
                    <h3 class="titre-s">{{ $realisation->titre }}</h3>
                    @if ($realisation->description)<p class="doux">{{ $realisation->description }}</p>@endif
                </li>
            @endforeach
        </ol>
    </section>
@endif
