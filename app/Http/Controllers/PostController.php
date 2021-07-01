<?php

namespace App\Http\Controllers;

use App\Models\{Post, Topic};
use App\Transfomers\PostTransformer;
use App\Http\Requests\{StorePostRequest, UpdatePostRequest};

class PostController extends Controller
{
    public function store(StorePostRequest $request, Topic $topic)
    {
        $post = new Post();
        $post->body = $request->body;
        $post->user()->associate($request->user());

        $topic->posts()->save($post);

        return fractal()
            ->item($post)
            ->transformWith(new PostTransformer())
            ->parseIncludes(['user'])
            ->toArray();
    }

    public function update(UpdatePostRequest $request, Topic $topic, Post $post)
    {
        $this->authorize('update', $post);

        $post->body = $request->get('body', $post->body);

        $post->save();

        return fractal()
            ->item($post)
            ->parseIncludes(['user'])
            ->transformWith(new PostTransformer())
            ->toArray();
    }

    public function delete(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response(null, 204);
    }
}
