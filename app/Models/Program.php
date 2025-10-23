<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title_id','title_en','title_ar',
        'desc_id','desc_en','desc_ar',
        'is_published','sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function titleFor(?string $loc = null): string
    {
        $loc = $loc ?: app()->getLocale();
        $map = ['id'=>'title_id','en'=>'title_en','ar'=>'title_ar'];
        $k = $map[$loc] ?? 'title_id';
        return $this->$k
            ?? $this->title_id
            ?? $this->title_en
            ?? $this->title_ar
            ?? '';
    }

    public function descFor(?string $loc = null): ?string
    {
        $loc = $loc ?: app()->getLocale();
        $map = ['id'=>'desc_id','en'=>'desc_en','ar'=>'desc_ar'];
        $k = $map[$loc] ?? 'desc_id';
        return $this->$k
            ?? $this->desc_id
            ?? $this->desc_en
            ?? $this->desc_ar
            ?? null;
    }

    public function scopePublished($q) {
        return $q->where('is_published', true);
    }

    public function scopeOrdered($q) {
        return $q->orderBy('sort_order')->orderBy('id');
    }
}
