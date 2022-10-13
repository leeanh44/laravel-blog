<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $with = ['category', 'author'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, fn($query, $search) =>
            $query->where(fn($query) =>
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%')
            )
        );

        $query->when($filters['category'] ?? false, fn($query, $category) =>
            $query->whereHas('category', fn ($query) =>
                $query->where('slug', $category)
            )
        );

        $query->when($filters['author'] ?? false, fn($query, $author) =>
            $query->whereHas('author', fn ($query) =>
                $query->where('username', $author)
            )
        );
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
    * Get the image path.
    *
    * @return string
    */
    public function getImagePathAttribute()
    {
        switch (true) {
            case empty($this->thumbnail):
                return '/images/logo.jpeg';
            case Storage::exists($this->thumbnail):
                return '/storage' . ((\App::environment() === 'local') ? '/public/' : '/' ) . $this->thumbnail;
            case @is_array(getimagesize($this->thumbnail)):
                return $this->thumbnail;
            default:
                return '/images/logo.jpeg';
        }
    }

    /**
    * Count read.
    */
    public function incrementReadCount()
    {
        $this->reads++;

        return $this->save();
    }
}
