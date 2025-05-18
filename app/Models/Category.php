<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    // Loại bỏ 'slug' khỏi $fillable để nó không thể được đặt trực tiếp

    /**
     * Boot function từ Model
     * Dùng để gắn các sự kiện khi tạo/cập nhật model
     */
    protected static function boot()
    {
        parent::boot();

        // Tự động tạo slug khi tạo mới category
        static::creating(function ($category) {
            $category->slug = $category->generateUniqueSlug($category->name);
        });

        // Tự động cập nhật slug khi cập nhật name của category
        static::updating(function ($category) {
            // Chỉ cập nhật slug nếu name thay đổi
            if ($category->isDirty('name')) {
                $category->slug = $category->generateUniqueSlug($category->name);
            }
        });
    }

    /**
     * Tạo slug duy nhất từ name
     * 
     * @param string $name
     * @return string
     */
    protected function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        // Kiểm tra xem slug đã tồn tại chưa
        while (static::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    public function mangas()
    {
        return $this->belongsToMany(Manga::class, 'category_manga');
    }
}