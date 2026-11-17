<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsTag;

class NewsController extends Controller
{
    public function index()
    {
        $cart = new CartController();

        $news = News::published()
            ->with(['category', 'tags'])
            ->latest()
            ->paginate(9);

        $newsCategories = NewsCategory::withCount('news')->get();
        $recentNews = News::published()->latest()->take(5)->get();
        $totalNews = News::published()->count();
        $categories = Category::all();

        $metaData = [
            'title' => 'Noticias | Productos Occidente, C.A.',
            'description' => 'Entérate de las últimas noticias sobre Productos Occidente, patrocinios deportivos, nuevos productos y eventos.',
            'keywords' => 'noticias, productos occidente, deportes, patrocinio, eventos, construcción',
        ];

        return view('news.index', [
            'news' => $news,
            'newsCategories' => $newsCategories,
            'totalNews' => $totalNews,
            'recentNews' => $recentNews,
            'categories' => $categories,
            'cart_products' => $cart->show_products(),
            'metaData' => $metaData,
        ]);
    }

    public function show(News $news)
    {
        $cart = new CartController();

        if (! $news->is_published) {
            abort(404);
        }

        $categories = Category::all();

        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->where('category_id', $news->category_id)
            ->with(['category', 'tags'])
            ->latest()
            ->take(3)
            ->get();

        $recentNews = News::published()
            ->where('id', '!=', $news->id)
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        $newsCategories = NewsCategory::withCount('news')->get();
        $totalNews = News::published()->count();

        $metaData = [
            'title' => $news->seo_title ?? $news->title.' | Productos Occidente',
            'description' => $news->seo_description ?? $news->excerpt,
            'keywords' => $news->tags->pluck('name')->implode(', ').', productos occidente, noticias',
            'og_image' => $news->image ? 'images/news/'.$news->image : null,
        ];

        return view('news.detail', [
            'news' => $news,
            'relatedNews' => $relatedNews,
            'recentNews' => $recentNews,
            'newsCategories' => $newsCategories,
            'totalNews' => $totalNews,
            'categories' => $categories,
            'cart_products' => $cart->show_products(),
            'metaData' => $metaData,
        ]);
    }

    public function byCategory(NewsCategory $category)
    {
        $cart = new CartController();

        $news = News::published()
            ->where('category_id', $category->id)
            ->with(['category', 'tags'])
            ->latest()
            ->paginate(9);

        $newsCategories = NewsCategory::withCount('news')->get();
        $recentNews = News::published()->latest()->take(5)->get();
        $totalNews = News::published()->count();
        $categories = Category::all();

        $metaData = [
            'title' => $category->name.' | Noticias Productos Occidente',
            'description' => $category->description,
            'keywords' => $category->name.', noticias, productos occidente',
        ];

        return view('news.index', [
            'news' => $news,
            'newsCategories' => $newsCategories,
            'totalNews' => $totalNews,
            'recentNews' => $recentNews,
            'currentCategory' => $category,
            'categories' => $categories,
            'cart_products' => $cart->show_products(),
            'metaData' => $metaData,
        ]);
    }

    public function byTag(NewsTag $tag)
    {
        $cart = new CartController();

        $news = News::published()
            ->whereHas('tags', function ($query) use ($tag) {
                $query->where('news_tags.id', $tag->id);
            })
            ->with(['category', 'tags'])
            ->latest()
            ->paginate(9);

        $newsCategories = NewsCategory::withCount('news')->get();
        $recentNews = News::published()->latest()->take(5)->get();
        $totalNews = News::published()->count();
        $categories = Category::all();

        $metaData = [
            'title' => 'Etiqueta: '.$tag->name.' | Noticias Productos Occidente',
            'description' => 'Noticias tagged con '.$tag->name,
            'keywords' => $tag->name.', noticias, productos occidente',
        ];

        return view('news.index', [
            'news' => $news,
            'newsCategories' => $newsCategories,
            'totalNews' => $totalNews,
            'recentNews' => $recentNews,
            'currentTag' => $tag,
            'categories' => $categories,
            'cart_products' => $cart->show_products(),
            'metaData' => $metaData,
        ]);
    }
}
