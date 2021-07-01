<?php

namespace App\Transfomers;

use App\Models\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user'];

    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'body' => $post->body,
            'likes_count' => $post->likes->count(),
            'created_at' => $post->created_at->toDateTimeString(),
            'created_at_human' => $post->created_at->diffForHumans(),
        ];
    }

    public function includeUser(Post $post)
    {
        return $this->item($post->user, new UserTransformer());
    }

    public function includeLikes(Post $post)
    {
        return $this->collection($post->likes->pluck('user'), new UserTransformer());
    }
}
