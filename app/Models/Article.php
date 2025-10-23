<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;
use App\Models\Tag;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'author_id',
        'title_id', 'title_en', 'title_ar',
        'slug', 'hero_image',
        'excerpt_id', 'excerpt_en', 'excerpt_ar',
        'meta_title_id','meta_title_en','meta_title_ar',
        'meta_desc_id','meta_desc_en','meta_desc_ar',
        'is_published', 'status', 'published_at', 'scheduled_for',
        'is_featured','is_hot','hot_until','pinned_until',
        'view_count','comment_count','share_count','reading_time',
    ];

    protected $casts = [
        'is_published'  => 'bool',
        'is_featured'   => 'bool',
        'is_hot'        => 'bool',
        'published_at'  => 'datetime',
        'scheduled_for' => 'datetime',
        'hot_until'     => 'datetime',
        'pinned_until'  => 'datetime',
        'view_count'    => 'integer',
        'comment_count' => 'integer',
        'share_count'   => 'integer',
        'reading_time'  => 'integer',
    ];

    /** RELATIONS */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function sections()
    {
        return $this->hasMany(ArticleSection::class)
            ->orderBy('sort_order')->orderBy('id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(ArticleLike::class);
    }

    /** SCOPES */
    public function scopePublished($q)
    {
        return $q->where('status','published')
                 ->whereNotNull('published_at')
                 ->where('published_at','<=', now());
    }

    public function scopeRecent($q)
    {
        return $q->published()->orderByDesc('published_at');
    }

    public function scopeFeatured($q)
    {
        return $q->published()->where('is_featured', true);
    }

    public function scopeHot($q)
    {
        return $q->published()
                 ->where('is_hot', true)
                 ->where(function($qq){
                     $qq->whereNull('hot_until')->orWhere('hot_until','>=', now());
                 });
    }

    public function scopeTop($q)
    {
        return $q->published()->orderByDesc('view_count');
    }

    public function scopeSearchTitle($q, string $term)
    {
        return $q->whereFullText(['title_id','title_en','title_ar','slug'], $term);
    }

    /** HELPERS (fallback judul) */
    public function titleFor(?string $locale = null): string
    {
        $locale = $locale ?: app()->getLocale();
        return $this->firstNonEmptyString(
            $this->{"title_{$locale}"} ?? null,
            $this->title_id ?? null,
            $this->title_en ?? null,
            $this->title_ar ?? null,
        ) ?? '';
    }

    protected static function booted(): void
    {
        static::deleting(function (Article $article) {
            if ($article->isForceDeleting()) {
                $article->sections()->withTrashed()->forceDelete();
            } else {
                $article->sections()->delete();
            }
        });

        static::restoring(function (Article $article) {
            $article->sections()->withTrashed()->restore();
        });
    }

    protected function firstNonEmptyString(?string ...$values): ?string
    {
        foreach ($values as $v) {
            if (is_string($v) && trim($v) !== '') return $v;
        }
        return null;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'article_category', 'article_id', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag', 'article_id', 'tag_id');
    }
}
