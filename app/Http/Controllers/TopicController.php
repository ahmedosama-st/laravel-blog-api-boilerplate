<?php

namespace App\Http\Controllers;

use App\Models\{Post, Topic};
use App\Transfomers\TopicTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use App\Http\Requests\{StoreTopicRequest, UpdateTopicRequest};

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::latestFirst()->paginate(3);
        $topicsCollection = $topics->getCollection();

        return fractal()
            ->collection($topicsCollection)
            ->parseIncludes(['user'])
            ->transformWith(new TopicTransformer())
            ->paginateWith(new IlluminatePaginatorAdapter($topics))
            ->toArray();
    }

    public function show(Topic $topic)
    {
        return fractal()
            ->item($topic)
            ->parseIncludes(['user', 'posts', 'posts.user', 'posts.likes'])
            ->transformWith(new TopicTransformer())
            ->toArray();
    }

    public function store(StoreTopicRequest $request)
    {
        $topic = new Topic();
        $topic->title = $request->title;
        $topic->user()->associate($request->user());

        $post = new Post();
        $post->body = $request->body;
        $post->user()->associate($request->user());

        $topic->save();
        $topic->posts()->save($post);

        return fractal()
            ->item($topic)
            ->parseIncludes(['user', 'posts', 'posts.user'])
            ->transformWith(new TopicTransformer())
            ->toArray();
    }

    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);

        $topic->title = $request->get('title', $topic->title);

        $topic->save();

        return fractal()
            ->item($topic)
            ->parseIncludes(['user'])
            ->transformWith(new TopicTransformer())
            ->toArray();
    }

    public function delete(Topic $topic)
    {
        $this->authorize('delete', $topic);

        $topic->delete();

        return response(null, 204);
    }
}
