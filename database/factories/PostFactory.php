<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(6);  // titre aléatoire
        $published = $this->faker->boolean(80);    // 60% de chances d’être publié

        return [
            'user_id' => User::factory(),     // associe un auteur
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'body' => implode("\n\n", $this->faker->paragraphs(5)),    // slug unique-ish
            'status' => $published ? 'published' : 'draft',
            'published_at' => $published ? now()->subDays(rand(0, 30)) : null,
        ];
    }
}
