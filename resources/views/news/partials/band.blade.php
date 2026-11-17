{{--
    Banda de noticias para la portada. Reutiliza la tarjeta de la sección.
    $items  Collection<News>  noticias a mostrar (3 encajan en la rejilla)
--}}
@if ($items->isNotEmpty())
    <section class="nw nw-band" aria-labelledby="nw-band-title">
        <div class="container">
            <div class="nw-band-head">
                <div>
                    <p class="nw-eyebrow">Sala de prensa</p>
                    <h2 class="nw-band-title" id="nw-band-title">Lo último de Occidente</h2>
                    <span class="nw-rule" aria-hidden="true"></span>
                    <p class="nw-band-lede">Obras, alianzas y patrocinios de la marca en todo el país.</p>
                </div>

                <a href="{{ route('news.index') }}" class="nw-band-all">
                    Ver todas las noticias <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>

            <div class="nw-grid">
                @foreach ($items as $item)
                    @include('news.partials.card', ['item' => $item, 'label' => 'Leer noticia'])
                @endforeach
            </div>
        </div>
    </section>
@endif
