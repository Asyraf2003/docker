<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryImage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title_id',
        'title_en',
        'title_ar',
        'description_id',
        'description_en',
        'description_ar',        
        'image_path',
        'link_url',
        'is_published',
        'sort_order',
        'published_at',
    ];

    public function scopePublished($q){ return $q->where('is_published', true); }
    public function scopeOrdered($q){ return $q->orderBy('sort_order')->latest('published_at'); }

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function scopeSearch($q, string $term)
    {
        $like = '%'.$term.'%';
        $q->where(function ($w) use ($like) {
            $w->where('title_id', 'like', $like)
              ->orWhere('title_en', 'like', $like)
              ->orWhere('title_ar', 'like', $like)
              ->orWhere('description_id', 'like', $like)
              ->orWhere('description_en', 'like', $like)
              ->orWhere('description_ar', 'like', $like);
        });
    }

    public function scopeDraft($q)
    {
        return $q->where(function ($w) {
            $w->where('is_published', false)
              ->orWhereNull('published_at');
        });
    }

    public function scopePublishedNow($q)
    {
        return $q->where('is_published', true)
                 ->whereNotNull('published_at')
                 ->where('published_at', '<=', now());
    }

    public function scopeScheduled($q)
    {
        return $q->where('is_published', true)
                 ->whereNotNull('published_at')
                 ->where('published_at', '>', now());
    }

    public function scopeSortByParam($q, ?string $sort)
    {
        switch ($sort) {
            case 'oldest':
                return $q->orderBy('published_at')->orderBy('created_at');
            case 'order_asc':
                return $q->orderBy('sort_order')
                         ->orderByDesc('published_at')
                         ->orderByDesc('created_at');
            case 'order_desc':
                return $q->orderByDesc('sort_order')
                         ->orderByDesc('published_at')
                         ->orderByDesc('created_at');
            case 'latest':
            default:
                return $q->orderByDesc('published_at')
                         ->orderByDesc('created_at');
        }
    }
}
