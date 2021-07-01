<?php

namespace App\Policies;

use App\Models\{Topic, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Topic $topic)
    {
        return $user->ownsTopic($topic);
    }

    public function delete(User $user, Topic $topic)
    {
        return $user->ownsTopic($topic);
    }
}
