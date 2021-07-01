<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Transfomers\UserTransformer;

class UserController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $user = new User();
        $user->username= $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer())
            ->toArray();
    }
}
