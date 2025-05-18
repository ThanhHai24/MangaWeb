<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'username',
        'displayname',
        'email',
        'password',
        'avatar',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function mangas()
    {
        return $this->hasMany(Manga::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function bookmarks()
    {
        return $this->belongsToMany(Manga::class, 'bookmarks')->withTimestamps();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function readingHistories()
    {
        return $this->hasMany(ReadingHistory::class);
    }

        public function isAdmin()
    {
        return $this->role === 'admin'; // hoặc role_id === 1, tùy vào cách bạn định nghĩa quyền
    }
}