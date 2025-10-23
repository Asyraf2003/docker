<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleSection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'article_id', 'type',
        'body_id', 'body_en', 'body_ar',
        'image_path', 'image_alt_id', 'image_alt_en', 'image_alt_ar',
        'sort_order',
    ];

    protected $touches = ['article'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('sort_order')->orderBy('id');
    }

    public function bodyFor(?string $locale = null): ?string
    {
        $locale = $locale ?: app()->getLocale();
        return $this->firstNonEmptyString(
            $this->{"body_{$locale}"} ?? null,
            $this->body_id ?? null,
            $this->body_en ?? null,
            $this->body_ar ?? null,
        );
    }

    public function imageAltFor(?string $locale = null): ?string
    {
        $locale = $locale ?: app()->getLocale();
        return $this->firstNonEmptyString(
            $this->{"image_alt_{$locale}"} ?? null,
            $this->image_alt_id ?? null,
            $this->image_alt_en ?? null,
            $this->image_alt_ar ?? null,
        );
    }

    protected function firstNonEmptyString(?string ...$values): ?string
    {
        foreach ($values as $v) {
            if (is_string($v) && trim($v) !== '') return $v;
        }
        return null;
    }
}
