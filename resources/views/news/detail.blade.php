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
    $shareUrl = urlencode(url()->current());
    $shareTitle = urlencode($news->title);
@endphp

<main class="nw nw-detail">
    @if (session('message'))
        @include('templates.message')
    @endif

    {{-- Hero: titular a la izquierda, imagen del artículo a la derecha --}}
    <section class="nw-hero">
        <div class="container">
            <div class="nw-hero-inner">
                <div class="nw-masthead">
                    <ul class="nw-breadcrumb">
                        <li><a href="{{ route('index') }}">Inicio</a></li>
                        <li><a href="{{ route('news.index') }}">Noticias</a></li>
                        @if ($news->category)
                            <li><a href="{{ route('news.category', $news->category) }}">{{ $news->category->name }}</a></li>
                        @endif
                        <li><span aria-current="page">{{ Str::limit($news->title, 34) }}</span></li>
                    </ul>

                    <h1 class="nw-title">{{ $news->title }}</h1>
                    <span class="nw-rule" aria-hidden="true"></span>

                    <div class="nw-meta">
                        <span>
                            <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                            {{ $news->created_at ? $news->created_at->translatedFormat('d M Y') : 'Reciente' }}
                        </span>
                        @if ($news->category)
                            <span>
                                <i class="fa-regular fa-folder" aria-hidden="true"></i>
                                {{ $news->category->name }}
                            </span>
                        @endif
                        <span>
                            <i class="fa-regular fa-user" aria-hidden="true"></i>
                            Editorial Productos Occidente
                        </span>
                    </div>
                </div>

                <div class="nw-hero-figure">
                    <img src="{{ $news->image ? asset("images/news/{$news->image}") : asset('images/news-placeholder.svg') }}"
                         alt="{{ $news->title }}" fetchpriority="high" decoding="async">
                </div>
            </div>
        </div>
    </section>

    <div class="container nw-body">
        <div class="nw-article-wrap">
            <article class="nw-article">
                @if ($news->excerpt)
                    <p class="nw-article-lede">{{ $news->excerpt }}</p>
                @endif

                <div class="nw-article-body">
                    @include("news.content.{$news->content_file}")
                </div>

                @if ($news->tags->isNotEmpty())
                    <div class="nw-article-tags">
                        <span class="nw-tags-label">Etiquetas</span>
                        @foreach ($news->tags as $tag)
                            <a href="{{ route('news.tag', $tag) }}" class="nw-tag">#{{ $tag->name }}</a>
                        @endforeach
                    </div>
                @endif

                <div class="nw-share">
                    <span class="nw-share-label">Comparte y síguenos</span>
                    <div class="nw-share-list">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                           target="_blank" rel="noopener" class="nw-share-btn nw-share-facebook"
                           aria-label="Compartir en Facebook">
                            <i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
                        </a>
                        {{-- Instagram no acepta enlaces prellenados: lleva a nuestro perfil --}}
                        <a href="https://www.instagram.com/prodoccidente"
                           target="_blank" rel="noopener" class="nw-share-btn nw-share-instagram"
                           aria-label="Síguenos en Instagram">
                            <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                        </a>
                        <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}"
                           target="_blank" rel="noopener" class="nw-share-btn nw-share-whatsapp"
                           aria-label="Compartir en WhatsApp">
                            <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                        </a>
                        <a href="mailto:?subject={{ $shareTitle }}&body={{ urlencode($news->excerpt."\n\n".url()->current()) }}"
                           class="nw-share-btn nw-share-email" aria-label="Compartir por correo">
                            <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </article>

            <aside class="nw-aside">
                @if ($recentNews->isNotEmpty())
                    <div class="nw-aside-block">
                        <h2 class="nw-aside-title">Más recientes</h2>
                        <div class="nw-recent">
                            @foreach ($recentNews as $recent)
                                <a href="{{ route('news.show', $recent) }}" class="nw-recent-item">
                                    <span class="nw-recent-thumb">
                                        <img src="{{ $recent->image ? asset("images/news/{$recent->image}") : asset('images/news-placeholder.svg') }}"
                                             alt="" loading="lazy" decoding="async">
                                    </span>
                                    <span class="nw-recent-info">
                                        <span class="nw-recent-title">{{ Str::limit($recent->title, 52) }}</span>
                                        <span class="nw-recent-date">
                                            {{ $recent->created_at ? $recent->created_at->translatedFormat('d M Y') : 'Reciente' }}
                                        </span>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="nw-aside-block">
                    <h2 class="nw-aside-title">Categorías</h2>
                    @include('news.partials.chips', [
                        'variant' => 'wrap',
                        'currentCategory' => $news->category,
                    ])
                </div>

                <a href="{{ route('news.index') }}" class="nw-back">
                    <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Volver a noticias
                </a>
            </aside>
        </div>
    </div>

    @if ($relatedNews->isNotEmpty())
        <section class="nw-related">
            <div class="container">
                <div class="nw-section-head">
                    <h2 class="nw-section-title">Más de {{ $news->category?->name ?? 'noticias' }}</h2>
                    <a href="{{ $news->category ? route('news.category', $news->category) : route('news.index') }}"
                       class="nw-more">
                        Ver todas <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>

                <div class="nw-grid">
                    @foreach ($relatedNews as $item)
                        @include('news.partials.card', ['item' => $item])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @include('page.partials.display_whatsapp')
</main>

@include('templates.footer')
<script src="{{ asset('js/display_whatsapp.js') }}"></script>
@endsection
