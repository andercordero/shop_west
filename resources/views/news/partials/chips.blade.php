{{--
    Filtro de categorías. Variante 'rail' en el listado, 'wrap' en la barra lateral.
    $newsCategories  Collection  categorías con news_count
    $totalNews       int         total de noticias publicadas
    $variant         string      'rail' | 'wrap' (opcional, 'rail')
    $currentCategory NewsCategory categoría activa (opcional)
    $currentTag      NewsTag     etiqueta activa (opcional)
--}}
@php
    $variant = $variant ?? 'rail';
    // Puede llegar null explícito (el detalle pasa $news->category), no solo indefinido
    $currentCategory = $currentCategory ?? null;
    $currentTag = $currentTag ?? null;
    $filtered = $currentCategory || $currentTag;
@endphp

<div class="nw-chips nw-chips-{{ $variant }}">
    @if ($variant === 'rail')
        <span class="nw-rail-label">Filtrar</span>
    @endif

    <a href="{{ route('news.index') }}"
       class="nw-chip {{ $filtered ? '' : 'is-active' }}"
       @if (! $filtered) aria-current="page" @endif>
        Todas
        <span class="nw-chip-count">{{ $totalNews }}</span>
    </a>

    @foreach ($newsCategories as $cat)
        @php $activeCat = $currentCategory && $currentCategory->id === $cat->id; @endphp
        {{-- Una categoría vacía no es un filtro útil: solo aparece si estás dentro de ella --}}
        @continue($cat->news_count === 0 && ! $activeCat)
        <a href="{{ route('news.category', $cat) }}"
           class="nw-chip {{ $activeCat ? 'is-active' : '' }}"
           @if ($activeCat) aria-current="page" @endif>
            {{ $cat->name }}
            <span class="nw-chip-count">{{ $cat->news_count }}</span>
        </a>
    @endforeach

    @if ($currentTag)
        <span class="nw-chip is-active">#{{ $currentTag->name }}</span>
    @endif
</div>
