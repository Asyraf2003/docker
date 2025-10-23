<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotInfo extends Model
{
    protected $fillable = [
        'title_id','title_en','title_ar','url',
        'starts_at','ends_at','is_active','sort_order',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
        'is_active' => 'bool',
        'sort_order'=> 'integer',
    ];

    /** SCOPES */
    public function scopeActiveNow($q)
    {
        $now = now();
        return $q->where('is_active', true)
                 ->where(function($qq) use ($now){
                     $qq->whereNull('starts_at')->orWhere('starts_at','<=',$now);
                 })
                 ->where(function($qq) use ($now){
                     $qq->whereNull('ends_at')->orWhere('ends_at','>=',$now);
                 })
                 ->orderBy('sort_order')->orderBy('id');
    }
}
