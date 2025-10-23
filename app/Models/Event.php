<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title_id','title_en','title_ar',
        'place_id','place_en','place_ar',
        'event_date','link_url',
        'is_published','sort_order',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function titleFor(?string $loc = null): string {
        $loc = $loc ?: app()->getLocale();
        $map = ['id'=>'title_id','en'=>'title_en','ar'=>'title_ar'];
        $k = $map[$loc] ?? 'title_id';
        return $this->$k ?? $this->title_id ?? $this->title_en ?? $this->title_ar ?? '';
    }

    public function placeFor(?string $loc = null): ?string {
        $loc = $loc ?: app()->getLocale();
        $map = ['id'=>'place_id','en'=>'place_en','ar'=>'place_ar'];
        $k = $map[$loc] ?? 'place_id';
        return $this->$k ?? $this->place_id ?? $this->place_en ?? $this->place_ar ?? null;
    }

    public function scopePublished($q) {
        return $q->where('is_published', true);
    }

    public function scopeUpcoming($q) {
        return $q->where('event_date', '>=', now());
    }

    public function scopeOrdered($q) {
        return $q->orderBy('event_date')->orderBy('sort_order');
    }
}
