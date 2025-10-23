<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Http\Requests\StoreArticleRequest;
// use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\ArticleSection;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $q       = trim($request->get('q', ''));
        $sort    = $request->get('sort', 'published_at_desc');
        $status  = $request->get('status'); // draft|scheduled|published|archived|null
        $catSlug = $request->get('category');
        $tagSlug = $request->get('tag');
        $feature = $request->get('featured'); // yes
        $hot     = $request->get('hot');      // yes

        $articles = Article::query()
            ->when($q, fn($qq)=>$qq->whereFullText(['title_id','title_en','title_ar','slug'],$q))
            ->when($status, fn($qq)=>$qq->where('status',$status))
            ->when($feature==='yes', fn($qq)=>$qq->where('is_featured',true))
            ->when($hot==='yes', fn($qq)=>$qq->where('is_hot',true))
            ->when($catSlug, function($qq) use($catSlug){
                $qq->whereHas('categories', fn($c)=>$c->where('slug',$catSlug));
            })
            ->when($tagSlug, function($qq) use($tagSlug){
                $qq->whereHas('tags', fn($t)=>$t->where('slug',$tagSlug));
            })
            ->when($sort==='published_at_asc', fn($qq)=>$qq->orderBy('published_at','asc'))
            ->when($sort==='title_asc', fn($qq)=>$qq->orderBy('title_id','asc'))
            ->when($sort==='title_desc', fn($qq)=>$qq->orderBy('title_id','desc'))
            ->when($sort==='views_desc', fn($qq)=>$qq->orderBy('view_count','desc'))
            ->when($sort==='published_at_desc', fn($qq)=>$qq->orderBy('published_at','desc'))
            ->orderByDesc('id')
            ->with(['author','categories','tags'])
            ->paginate(12)
            ->withQueryString();

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::active()->ordered()->get();
        $tags = Tag::popular()->get();
        return view('admin.articles.create', compact('categories','tags'));
    }

    public function store(Request $request)
    {
        $data = $request->all(); // ganti ke FormRequest nanti kalau siap

        DB::beginTransaction();
        try {
            $heroPath = null;
            if ($request->hasFile('hero_image')) {
                $heroPath = $request->file('hero_image')->store('articles/hero', 'public');
            }

            $slugSource = $data['slug'] ?? ($data['title_id'] ?? Str::random(8));
            $slug = $this->makeUniqueSlug($slugSource);

            $article = Article::create([
                'author_id' => Auth::id(),
                'title_id'     => trim($data['title_id']),
                'title_en'     => $data['title_en'] ?? '',
                'title_ar'     => $data['title_ar'] ?? '',
                'slug'         => $slug,
                'hero_image'   => $heroPath,

                'excerpt_id'   => $data['excerpt_id'] ?? null,
                'excerpt_en'   => $data['excerpt_en'] ?? null,
                'excerpt_ar'   => $data['excerpt_ar'] ?? null,

                'meta_title_id'=> $data['meta_title_id'] ?? null,
                'meta_title_en'=> $data['meta_title_en'] ?? null,
                'meta_title_ar'=> $data['meta_title_ar'] ?? null,
                'meta_desc_id' => $data['meta_desc_id'] ?? null,
                'meta_desc_en' => $data['meta_desc_en'] ?? null,
                'meta_desc_ar' => $data['meta_desc_ar'] ?? null,

                'is_published' => (bool)($data['is_published'] ?? false),
                'status'       => $data['status'] ?? 'draft',
                'published_at' => $data['published_at'] ?? null,
                'scheduled_for'=> $data['scheduled_for'] ?? null,

                'is_featured'  => (bool)($data['is_featured'] ?? false),
                'is_hot'       => (bool)($data['is_hot'] ?? false),
                'hot_until'    => $data['hot_until'] ?? null,
                'pinned_until' => $data['pinned_until'] ?? null,
            ]);

            $this->syncSections($article, $data['sections'] ?? []);
            $this->syncCategories($article, $data['category_ids'] ?? []);
            $this->syncTags($article, $data['tag_slugs'] ?? [], $data['tag_ids'] ?? []);

            $article->reading_time = $this->computeReadingMinutes($article);
            $article->save();

            DB::commit();
            return redirect()->route('admin.articles.index')->with('success','Artikel dibuat.');
        } catch (\Throwable $e) {
            DB::rollBack(); report($e);
            return back()->withErrors('Gagal menyimpan artikel: '.$e->getMessage())->withInput();
        }
    }

    public function show(Article $article)
    {
        $article->load(['sections','author','categories','tags']);
        return view('admin.article', compact('article'));
    }

    public function edit(Article $article)
    {
        $article->load(['sections','categories','tags']);
        $categories = Category::active()->ordered()->get();
        $tags = Tag::popular()->get();
        return view('admin.articles.edit', compact('article','categories','tags'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->all();

        DB::beginTransaction();
        try {
            $newSlug = $article->slug;
            if (array_key_exists('slug', $data) && filled($data['slug']) && $data['slug'] !== $article->slug) {
                $newSlug = $this->makeUniqueSlug($data['slug']);
            }

            $payload = [
                'title_id'     => $data['title_id'],
                'title_en'     => $data['title_en'] ?? '',
                'title_ar'     => $data['title_ar'] ?? '',
                'slug'         => $newSlug,

                'excerpt_id'   => $data['excerpt_id'] ?? null,
                'excerpt_en'   => $data['excerpt_en'] ?? null,
                'excerpt_ar'   => $data['excerpt_ar'] ?? null,

                'meta_title_id'=> $data['meta_title_id'] ?? null,
                'meta_title_en'=> $data['meta_title_en'] ?? null,
                'meta_title_ar'=> $data['meta_title_ar'] ?? null,
                'meta_desc_id' => $data['meta_desc_id'] ?? null,
                'meta_desc_en' => $data['meta_desc_en'] ?? null,
                'meta_desc_ar' => $data['meta_desc_ar'] ?? null,

                'is_published' => (bool)($data['is_published'] ?? false),
                'status'       => $data['status'] ?? $article->status,
                'published_at' => $data['published_at'] ?? $article->published_at,
                'scheduled_for'=> $data['scheduled_for'] ?? $article->scheduled_for,

                'is_featured'  => (bool)($data['is_featured'] ?? false),
                'is_hot'       => (bool)($data['is_hot'] ?? false),
                'hot_until'    => $data['hot_until'] ?? null,
                'pinned_until' => $data['pinned_until'] ?? null,
            ];

            $article->update($payload);

            if ($request->hasFile('hero_image')) {
                if ($article->hero_image && Storage::disk('public')->exists($article->hero_image)) {
                    Storage::disk('public')->delete($article->hero_image);
                }
                $path = $request->file('hero_image')->store('articles/hero', 'public');
                $article->hero_image = $path;
                $article->save();
            }

            $this->syncSections($article, $data['sections'] ?? []);
            $this->syncCategories($article, $data['category_ids'] ?? []);
            $this->syncTags($article, $data['tag_slugs'] ?? [], $data['tag_ids'] ?? []);

            $article->reading_time = $this->computeReadingMinutes($article);
            $article->save();

            DB::commit();
            return redirect()->route('admin.articles.index')->with('success', 'Artikel diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack(); report($e);
            return back()->withErrors('Gagal memperbarui artikel: '.$e->getMessage())->withInput();
        }
    }

    public function destroy(Article $article)
    {
        DB::beginTransaction();
        try {
            if ($article->hero_image && Storage::disk('public')->exists($article->hero_image)) {
                Storage::disk('public')->delete($article->hero_image);
            }
            foreach ($article->sections as $sec) {
                if ($sec->image_path && Storage::disk('public')->exists($sec->image_path)) {
                    Storage::disk('public')->delete($sec->image_path);
                }
            }
            $article->sections()->delete();
            $article->categories()->detach();
            $article->tags()->detach();
            $article->delete();

            DB::commit();
            return redirect()->route('admin.articles.index')->with('success', 'Artikel dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack(); report($e);
            return back()->withErrors('Gagal menghapus artikel: ' . $e->getMessage());
        }
    }

    /** ===== Helpers ===== */

    private function makeUniqueSlug(string $base): string
    {
        $slug = Str::slug($base);
        if ($slug === '') $slug = Str::random(8);
        $original = $slug; $i = 2;
        while (Article::withTrashed()->where('slug', $slug)->exists()) {
            $slug = "{$original}-{$i}";
            $i++;
        }
        return $slug;
    }

    private function syncSections(Article $article, array $sections): void
    {
        $existing = $article->sections()->get()->keyBy('id');

        foreach ($sections as $index => $sec) {
            $payload = [
                'type'          => in_array(($sec['type'] ?? 'paragraph'), ['paragraph','quote','image_only','embed'], true)
                                    ? $sec['type'] : 'paragraph',
                'body_id'       => $sec['body_id']      ?? null,
                'body_en'       => $sec['body_en']      ?? null,
                'body_ar'       => $sec['body_ar']      ?? null,
                'image_alt_id'  => $sec['image_alt_id'] ?? null,
                'image_alt_en'  => $sec['image_alt_en'] ?? null,
                'image_alt_ar'  => $sec['image_alt_ar'] ?? null,
                'sort_order'    => $sec['sort_order']   ?? $index,
            ];

            $hasFile = isset($sec['image']) && $sec['image'];

            if (!empty($sec['id']) && $existing->has($sec['id'])) {
                /** @var ArticleSection $model */
                $model = $existing->get($sec['id']);

                if (!empty($sec['remove_image'])) {
                    if ($model->image_path && Storage::disk('public')->exists($model->image_path)) {
                        Storage::disk('public')->delete($model->image_path);
                    }
                    $payload['image_path'] = null;
                }

                if ($hasFile) {
                    if ($model->image_path && Storage::disk('public')->exists($model->image_path)) {
                        Storage::disk('public')->delete($model->image_path);
                    }
                    $payload['image_path'] = $sec['image']->store('articles/sections', 'public');
                }

                $model->update($payload);
                $existing->forget($model->id);
            } else {
                if ($hasFile) {
                    $payload['image_path'] = $sec['image']->store('articles/sections', 'public');
                }
                $article->sections()->create($payload);
            }
        }

        foreach ($existing as $orphan) {
            if ($orphan->image_path && Storage::disk('public')->exists($orphan->image_path)) {
                Storage::disk('public')->delete($orphan->image_path);
            }
            $orphan->delete();
        }
    }

    private function syncCategories(Article $article, array $categoryIds): void
    {
        $ids = collect($categoryIds)->filter()->map(fn($v)=>(int)$v)->unique()->values()->all();
        $article->categories()->sync($ids);
    }

    private function syncTags(Article $article, array $tagSlugs = [], array $tagIds = []): void
    {
        $ids = collect($tagIds)->filter()->map(fn($v)=>(int)$v)->all();
        $slugs = collect($tagSlugs)->filter()->map(fn($v)=>Str::slug($v))->all();

        if (!empty($slugs)) {
            $existing = Tag::whereIn('slug', $slugs)->get()->keyBy('slug');
            foreach ($slugs as $slug) {
                if (!isset($existing[$slug])) {
                    $tag = Tag::create(['name'=>$slug, 'slug'=>$slug]);
                    $ids[] = $tag->id;
                } else {
                    $ids[] = $existing[$slug]->id;
                }
            }
        }

        $article->tags()->sync(array_values(array_unique($ids)));

        // Opsional: update use_count (kasar, bisa ganti observer)
        Tag::whereIn('id',$ids)->increment('use_count');
    }

    private function computeReadingMinutes(Article $article): int
    {
        $text = $article->sections()->pluck('body_id','id')->implode(' ')
              .' '.$article->sections()->pluck('body_en','id')->implode(' ')
              .' '.$article->sections()->pluck('body_ar','id')->implode(' ');
        $words = str_word_count(strip_tags($text));
        $wpm = 220; 
        return max(1, (int)ceil($words / $wpm));
    }
}
