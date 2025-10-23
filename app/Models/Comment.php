<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'article_id','user_id','guest_name','guest_email',
        'parent_id','body','status','ip','user_agent',
    ];

    protected $casts = [
        'article_id' => 'integer',
        'user_id'    => 'integer',
        'parent_id'  => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /** RELATIONS */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('id');
    }

    /** SCOPES */
    public function scopeApproved($q)
    {
        return $q->where('status','approved');
    }

    /** HELPERS */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }
}
