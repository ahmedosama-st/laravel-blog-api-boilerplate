<?php

namespace App\Transfomers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'username' => $user->username,
            'avatar' => $user->avatar(),
        ];
    }
}
