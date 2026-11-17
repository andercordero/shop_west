{{--
    Bloque de proyectos de la portada.
    Los datos son los mismos que muestra /proyectos (page/project.blade.php).
    La obra principal va primero y ocupa el cuadrante grande del mosaico.
--}}
@php
    $projects = [
        [
            'name' => 'Parque La Música',
            'image' => 'images/projects/parque_la_musica.webp',
            'alt' => 'Parque La Música, obra ejecutada con productos Occidente',
            'products' => ['Súper Extra Porcelanato', 'Imperplus', 'Stuco'],
            'lead' => true,
        ],
        [
            'name' => 'Catedral',
            'image' => 'images/projects/catedral.jpg',
            'alt' => 'Catedral revestida con Súper Extra Porcelanato',
            'products' => ['Súper Extra Porcelanato'],
        ],
        [
            'name' => 'Residencia Colinas del Viento',
            'image' => 'images/projects/lidotel.webp',
            'alt' => 'Residencia Colinas del Viento, impermeabilizada con Imperplus',
            'products' => ['Imperplus'],
        ],
        [
            'name' => 'Proyecto Esmeralda',
            'image' => 'images/projects/proyecto_esmeralda.jpeg',
            'alt' => 'Proyecto Esmeralda en Caracas',
            'products' => ['Súper Extra Porcelanato'],
        ],
        [
            'name' => 'Biotel',
            'image' => 'images/projects/biotel.jpg',
            'alt' => 'Biotel, construido con Stuco, Occiconcreto y Pego Supremo Blanco',
            'products' => ['Stuco', 'Occiconcreto', 'Pego Supremo'],
        ],
    ];
@endphp

<section class="projects pj" aria-labelledby="pj-title">
    <header>
        <h2 class="h2" id="pj-title">
            <i class="fa-solid fa-quote-left quotes" aria-hidden="true"></i>Proyectos<i
                class="fa-solid fa-quote-right quotes" aria-hidden="true"></i>
        </h2>
    </header>

    <p class="pj-lede">Obras donde nuestros productos ya están puestos. Cada una con lo que se usó en ella.</p>

    <div class="pj-grid">
        @foreach ($projects as $project)
            <a href="{{ route('project') }}" class="pj-tile {{ ($project['lead'] ?? false) ? 'pj-tile--lead' : '' }}">
                <img src="{{ asset($project['image']) }}" alt="{{ $project['alt'] }}"
                     loading="lazy" decoding="async">
                <div class="pj-tile-body">
                    <h3 class="pj-tile-name">{{ $project['name'] }}</h3>
                    <ul class="pj-tile-products">
                        <li class="pj-sr">Productos usados:</li>
                        @foreach ($project['products'] as $product)
                            <li>{{ $product }}</li>
                        @endforeach
                    </ul>
                </div>
            </a>
        @endforeach
    </div>

    <div class="pj-all-wrap">
        <a href="{{ route('project') }}" class="pj-all">
            Ver todos los proyectos <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>
    </div>
</section>
