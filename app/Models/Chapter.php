<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'manga_id',
        'title',
        'chapter_number',
        'images',
        'content',
        'views'
    ];

    protected $casts = [
        'images' => 'array' // Tự động chuyển đổi JSON thành mảng
    ];

    // Set the slug automatically before saving
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($chapter) {
            $chapter->slug = 'chapter' . $chapter->chapter_number;
        });

        static::updating(function ($chapter) {
            if ($chapter->isDirty('chapter_number')) {
                $chapter->slug = 'chapter' . $chapter->chapter_number;
            }
        });
    }

    // Relationships
    public function manga()
    {
        return $this->belongsTo(Manga::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function readingHistories()
    {
        return $this->hasMany(ReadingHistory::class);
    }

    // Accessor - Lấy chapter trước
    public function getPreviousChapterAttribute()
    {
        return $this->manga->chapters()
            ->where('chapter_number', '<', $this->chapter_number)
            ->orderBy('chapter_number', 'desc')
            ->first();
    }

    // Accessor - Lấy chapter kế tiếp
    public function getNextChapterAttribute()
    {
        return $this->manga->chapters()
            ->where('chapter_number', '>', $this->chapter_number)
            ->orderBy('chapter_number', 'asc')
            ->first();
    }
}
