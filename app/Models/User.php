<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable as FortifyTwoFactor;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, FortifyTwoFactor;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';
    public const ROLE_OTHER = 'other';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function role(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtolower($value),
            set: fn ($value) => strtolower($value)
        );
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function ppdb()
    {
        return $this->hasOne(Ppdb::class);
    }

    public function articles()
    {
        return $this->hasMany(\App\Models\Article::class, 'author_id');
    }

    public function articleLikes()
    {
        return $this->hasMany(\App\Models\ArticleLike::class);
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class);
    }
}

