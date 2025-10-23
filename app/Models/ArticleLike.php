<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleLike extends Model
{
    protected $fillable = [
        'article_id','user_id','fingerprint',
    ];

    protected $casts = [
        'article_id' => 'integer',
        'user_id'    => 'integer',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
