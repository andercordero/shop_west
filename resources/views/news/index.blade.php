@extends('template')

@section('title', $metaData['title'])
@section('description', $metaData['description'])
@section('keywords', $metaData['keywords'])

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Barlow:wght@500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/news.css') }}">
@endsection

@section('content')
@php
    $isFiltered = isset($currentCategory) || isset($currentTag);

    // La destacada solo tiene sentido en la portada sin filtros: es la última noticia.
    $items = $news->getCollection();
    $featured = (! $isFiltered && $news->currentPage() === 1 && $items->count() > 2) ? $items->first() : null;
    $rest = $featured ? $items->slice(1) : $items;

    if (isset($currentCategory)) {
        $heading = $currentCategory->name;
        $eyebrow = 'Categoría';
        $lede = $currentCategory->description ?: 'Todo lo publicado en esta categoría.';
    } elseif (isset($currentTag)) {
        $heading = $currentTag->name;
        $eyebrow = 'Etiqueta';
        $lede = 'Noticias marcadas con esta etiqueta.';
    } else {
        $heading = 'Noticias';
        $eyebrow = 'Sala de prensa';
        $lede = 'Patrocinios, obras, ferias y lanzamientos: lo que hacemos cuando no estamos fabricando.';
    }
@endphp

<main class="nw">
    @if (session('message'))
        @include('templates.message')
    @endif

    {{-- Hero: panel de titular + banner de fachada --}}
    <section class="nw-hero">
        <div class="container">
            <div class="nw-hero-inner">
                <div class="nw-masthead">
                    <p class="nw-eyebrow">{{ $eyebrow }}</p>
                    <h1 class="nw-title">{{ $heading }}</h1>
                    <span class="nw-rule" aria-hidden="true"></span>
                    <p class="nw-lede">{{ $lede }}</p>
                </div>

                <div class="nw-hero-figure">
                    <img src="{{ asset('images/banners/banner_correo_4.webp') }}"
                         alt="Fachada de una ferretería aliada de Productos Occidente"
                         width="1800" height="900" fetchpriority="high">
                </div>
            </div>
        </div>
    </section>

    {{-- Riel de categorías --}}
    <nav class="nw-rail" aria-label="Categorías de noticias">
        <div class="container">
            @include('news.partials.chips', ['variant' => 'rail'])
        </div>
    </nav>

    <section class="container nw-body">
        @if ($news->total() > 0)
            <div class="nw-section-head">
                <h2 class="nw-section-title">{{ $isFiltered ? 'Resultados' : 'Últimas publicaciones' }}</h2>
                <span class="nw-section-count">
                    {{ $news->total() }} {{ $news->total() === 1 ? 'noticia' : 'noticias' }}
                </span>
            </div>

            <div class="nw-grid">
                @if ($featured)
                    @include('news.partials.card', [
                        'item' => $featured,
                        'lead' => true,
                        'eager' => true,
                        'tags' => 3,
                        'label' => 'Leer noticia',
                        'flag' => 'Lo más reciente',
                    ])
                @endif

                @foreach ($rest as $item)
                    @include('news.partials.card', ['item' => $item])
                @endforeach
            </div>

            @if ($news->hasPages())
                <div class="nw-pagination">
                    {{ $news->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @else
            <div class="nw-empty">
                <h2>Todavía no hay nada por aquí</h2>
                <p>Publicamos novedades, patrocinios y eventos apenas ocurren. Vuelve pronto.</p>
                <a href="{{ route('news.index') }}" class="nw-btn">Ver todas las noticias</a>
            </div>
        @endif
    </section>

    @include('page.partials.display_whatsapp')
</main>

@include('templates.footer')
<script src="{{ asset('js/display_whatsapp.js') }}"></script>
@endsection
