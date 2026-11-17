{{--
    Tarjeta de noticia. Se usa en el listado, en la destacada y en relacionadas.
    $item   News        noticia a mostrar
    $lead   bool        variante destacada a ancho completo (opcional)
    $eager  bool        carga la imagen sin lazy, para la primera visible (opcional)
    $tags   int         cuántas etiquetas mostrar (opcional, 2)
    $label  string      texto del enlace de lectura (opcional, 'Leer')
    $flag   string      rótulo rojo sobre el título, solo en la destacada (opcional)
--}}
@php
    $lead = $lead ?? false;
    $eager = $eager ?? false;
    $tags = $tags ?? 2;
    $label = $label ?? 'Leer';
    $flag = $flag ?? null;
@endphp

<article class="nw-card {{ $lead ? 'nw-lead' : '' }}">
    <a href="{{ route('news.show', $item) }}" class="nw-card-figure" tabindex="-1" aria-hidden="true">
        @if ($item->category)
            <span class="nw-card-cat">{{ $item->category->name }}</span>
        @endif
        <img src="{{ $item->image ? asset("images/news/{$item->image}") : asset('images/news-placeholder.svg') }}"
             alt="" loading="{{ $eager ? 'eager' : 'lazy' }}" decoding="async">
    </a>

    <div class="nw-card-body">
        @if ($flag)
            <p class="nw-lead-flag">{{ $flag }}</p>
        @endif

        <p class="nw-card-date">
            {{ $item->created_at ? $item->created_at->translatedFormat('d M Y') : 'Reciente' }}
        </p>

        <h3 class="nw-card-title">
            <a href="{{ route('news.show', $item) }}">{{ $item->title }}</a>
        </h3>

        <p class="nw-card-excerpt">{{ $item->excerpt }}</p>

        <div class="nw-card-foot">
            <a href="{{ route('news.show', $item) }}" class="nw-more">
                {{ $label }} <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
            <div class="nw-tags">
                @foreach ($item->tags->take($tags) as $tag)
                    <a href="{{ route('news.tag', $tag) }}" class="nw-tag">#{{ $tag->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
</article>
