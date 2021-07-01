<?php

namespace App\Policies;

use App\Models\{Post, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Post $post)
    {
        return $user->ownsPost($post);
    }

    public function delete(User $user, Post $post)
    {
        return $user->ownsPost($post);
    }
}
