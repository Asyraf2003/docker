<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name_id','name_en','name_ar','slug',
        'parent_id','sort_order','is_active',
    ];

    protected $casts = [
        'is_active' => 'bool',
        'sort_order'=> 'integer',
    ];

    /** RELATIONS */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order');
    }

    /** SCOPES */
    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('sort_order')->orderBy('id');
    }
    public function articles()
    {
        return $this->belongsToMany(\App\Models\Article::class, 'article_category', 'category_id', 'article_id');
    }

}
