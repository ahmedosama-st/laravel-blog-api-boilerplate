<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\{Post, Topic};

class PostLikeController extends Controller
{
    public function store(Request $request, Topic $topic, Post $post)
    {
        $like = new Like();

        if ($request->user()->hasLikedPost($post)) {
            $post->likes()->delete($like);
        } else {
            $like->user()->associate($request->user());
            $post->likes()->save($like);
        }

        return response(null, 204);
    }
}
