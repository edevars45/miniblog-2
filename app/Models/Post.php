<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'body', 'status', 'published_at', 'user_id'];
    protected $casts = ['published_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Binding des routes par slug (/posts/{post:slug})
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // (optionnel)  Post::published() pour filtrer les publiés
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Génère un slug unique à partir du titre
    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $post->slug = static::uniqueSlug($post->title);
            }
        });

        static::updating(function (Post $post) {
            // Si tu veux garder des URLs stables, commente ce bloc
            if ($post->isDirty('title')) {
                $post->slug = static::uniqueSlug($post->title, $post->id);
            }
        });
    }

    protected static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'article';
        $slug = $base;
        $i = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
