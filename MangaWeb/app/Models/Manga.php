<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Manga extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'author',
        'artist',
        'status',
        'release_year',
        'user_id',
        'views',
        'is_featured'
    ];

    // Loại bỏ 'slug' khỏi $fillable để nó không thể được đặt trực tiếp

    /**
     * Boot function từ Model
     * Dùng để gắn các sự kiện khi tạo/cập nhật model
     */
    protected static function boot()
    {
        parent::boot();

        // Tự động tạo slug khi tạo mới manga
        static::creating(function ($manga) {
            $manga->slug = $manga->generateUniqueSlug($manga->title);
        });

        // Tự động cập nhật slug khi cập nhật title của manga
        static::updating(function ($manga) {
            // Chỉ cập nhật slug nếu title thay đổi
            if ($manga->isDirty('title')) {
                $manga->slug = $manga->generateUniqueSlug($manga->title);
            }
        });
    }

    /**
     * Tạo slug duy nhất từ title
     * 
     * @param string $title
     * @return string
     */
    protected function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        // Kiểm tra xem slug đã tồn tại chưa
        while (static::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_manga');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function bookmarkedBy()
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function readingHistories()
    {
        return $this->hasMany(ReadingHistory::class);
    }

    // Accessor - Tính trung bình rating của manga
    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating') ?: 0;
    }

    // Accessor - Lấy chapter mới nhất
    public function getLatestChapterAttribute()
    {
        return $this->chapters()->latest('chapter_number')->first();
    }
}