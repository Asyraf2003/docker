<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $q       = trim($request->get('q', ''));
        $catSlug = $request->get('category');
        $tagSlug = $request->get('tag');
        $sort    = $request->get('sort', 'recent'); // recent|top|featured

        $query = Article::with(['author','categories','tags'])
            ->when($q, fn($qq)=>$qq->whereFullText(['title_id','title_en','title_ar','slug'],$q))
            ->when($catSlug, fn($qq)=>$qq->whereHas('categories', fn($c)=>$c->where('slug',$catSlug)))
            ->when($tagSlug, fn($qq)=>$qq->whereHas('tags', fn($t)=>$t->where('slug',$tagSlug)))
            ->published();

        if ($sort === 'top') {
            $query->orderByDesc('view_count');
        } elseif ($sort === 'featured') {
            $query->where('is_featured',true)->orderByDesc('published_at');
        } else {
            $query->orderByDesc('published_at');
        }

        $articles = $query->paginate(12)->withQueryString();
        $categories = Category::active()->ordered()->get();
        $tags = Tag::popular()->limit(20)->get();

        return view('article', compact('articles','categories','tags','q','catSlug','tagSlug','sort'));
    }

    public function show(string $slug, Request $request)
    {
        $article = Article::with(['author','sections','categories','tags'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $key = 'viewed_article_'.$article->id;
        if (!$request->session()->has($key)) {
            $article->increment('view_count');
            $request->session()->put($key, true);
        }

        $replyTo = null;
        if ($rid = $request->integer('reply_to')) {
            $replyTo = $article->comments()
                ->approved()
                ->with('user:id,name,email')   // buat tampilkan nama di banner reply
                ->whereKey($rid)               // pastikan id-nya ada
                ->first();                     // null jika tidak valid
        }

        $related = Article::published()
            ->whereKeyNot($article->id)
            ->when($article->categories->isNotEmpty(), function($qq) use ($article){
                $catIds = $article->categories->pluck('id');
                $qq->whereHas('categories', fn($c) => $c->whereIn('categories.id', $catIds));
            })
            ->orderByDesc('published_at')
            ->limit(8)->get();

        $top      = Article::top()->limit(5)->get();
        $featured = Article::featured()->limit(4)->get();

        return view('article', compact('article','related','top','featured','replyTo'));
    }
}
