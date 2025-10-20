<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    // Peut créer si permission
    public function create(User $user): bool
    {
        return $user->can('posts.create');
    }

    // Peut mettre à jour s'il a la permission ET (est auteur OU est editor/admin)
    public function update(User $user, Post $post): bool
    {
        return $user->can('posts.edit') && (
            $post->user_id === $user->id || $user->hasRole(['editor', 'admin'])
        );
    }

    // Peut supprimer s'il a la permission ET (est auteur OU editor/admin)
    public function delete(User $user, Post $post): bool
    {
        return $user->can('posts.delete') && (
            $post->user_id === $user->id || $user->hasRole(['editor', 'admin'])
        );
    }

    // Publier / dépublier : permission dédiée
    public function publish(User $user, Post $post): bool
    {
        return $user->can('posts.publish');
    }
}