{{--
    Aliados comerciales por estado.
    $partnerStates  Collection<State>  solo estados activos que tienen aliados activos

    El mapa y la lista se enlazan por el código ISO del estado: cada <path> del SVG
    lleva data-code, y cada grupo de aliados lleva el mismo valor en data-state.
--}}
@if ($partnerStates->isNotEmpty())
    @php
        $totalPartners = $partnerStates->sum(fn ($state) => $state->commercialPartners->count());
        $firstCode = $partnerStates->first()->code;
    @endphp

    <section class="partner-section" id="aliados" aria-labelledby="pn-title">
        <header>
            <h2 class="h2" id="pn-title">
                <i class="fa-solid fa-quote-left quotes" aria-hidden="true"></i>Dónde encontrarnos<i
                    class="fa-solid fa-quote-right quotes" aria-hidden="true"></i>
            </h2>
        </header>

        <p class="pn-lede">
            {{ $totalPartners }} aliados comerciales en {{ $partnerStates->count() }}
            {{ $partnerStates->count() === 1 ? 'estado' : 'estados' }}.
            Elige uno en el mapa para ver quién vende nuestros productos ahí.
        </p>

        <div class="partner-content">
            <div class="map-container">
                @include('page.partials.mapa_venezuela')
            </div>

            <div class="pn-panel">
                {{-- Alternativa al mapa: navegable con teclado y usable en móvil --}}
                <div class="state-filter" role="tablist" aria-label="Estados con aliados">
                    @foreach ($partnerStates as $state)
                        <button type="button" role="tab" class="pn-chip {{ $loop->first ? 'active' : '' }}"
                                data-state="{{ $state->code }}" id="pn-tab-{{ $state->code }}"
                                aria-controls="pn-panel-{{ $state->code }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                            {{ $state->name }}
                            <span class="pn-chip-count">{{ $state->commercialPartners->count() }}</span>
                        </button>
                    @endforeach
                </div>

                <div class="partner-list">
                    @foreach ($partnerStates as $state)
                        <div class="partner-group {{ $loop->first ? '' : 'hide' }}" data-state="{{ $state->code }}"
                             id="pn-panel-{{ $state->code }}" role="tabpanel"
                             aria-labelledby="pn-tab-{{ $state->code }}"
                             @if (! $loop->first) hidden @endif>
                            <h3 class="state-title">{{ $state->name }}</h3>

                            <ul>
                                @foreach ($state->commercialPartners as $partner)
                                    <li class="pn-partner">
                                        @if ($partner->url)
                                            <a class="pn-partner-name" href="{{ $partner->url }}" target="_blank"
                                               rel="noopener">
                                                {{ $partner->name }}
                                                <i class="fa-solid fa-arrow-up-right-from-square"
                                                   aria-hidden="true"></i>
                                            </a>
                                        @else
                                            <p class="pn-partner-name">{{ $partner->name }}</p>
                                        @endif

                                        {{-- Dirección y teléfono en la misma línea: dos filas por aliado,
                                             no cuatro. Si no caben, el teléfono baja solo. --}}
                                        @if ($partner->address || $partner->phone)
                                            <div class="pn-partner-meta">
                                                @if ($partner->address)
                                                    <span class="pn-partner-line">
                                                        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                                                        {{ $partner->address }}
                                                    </span>
                                                @endif

                                                @if ($partner->phone)
                                                    <a class="pn-partner-line"
                                                       href="tel:{{ preg_replace('/[^0-9+]/', '', $partner->phone) }}">
                                                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                                                        {{ $partner->phone }}
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <p class="pn-credit">Mapa base: <a href="https://simplemaps.com" target="_blank" rel="noopener">simplemaps.com</a></p>
    </section>

    <script>
        // Estados con aliados; el resto del mapa queda apagado y sin interacción.
        window.partnerStateCodes = @json($partnerStates->pluck('code'));
        window.partnerInitialState = @json($firstCode);
    </script>
@endif
