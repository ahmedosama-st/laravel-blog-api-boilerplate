<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{PostController, PostLikeController, TopicController, UserController};

Route::middleware('auth:api')->get('/user', fn (Request $request) => $request->user());

Route::post('/register', [UserController::class, 'register']);

Route::group(['prefix' => 'topics'], function () {
    Route::get('/', [TopicController::class, 'index']);
    Route::get('/{topic}', [TopicController::class, 'show']);
    Route::post('/', [TopicController::class, 'store'])->middleware('auth:api');
    Route::patch('/{topic}', [TopicController::class, 'update'])->middleware('auth:api');
    Route::delete('/{topic}', [TopicController::class, 'delete'])->middleware('auth:api');

    Route::group(['prefix' => '/{topic}/posts'], function () {
        Route::post('/', [PostController::class, 'store'])->middleware('auth:api');
        Route::patch('/{post}', [PostController::class, 'update'])->middleware('auth:api');
        Route::delete('/{post}', [PostController::class, 'delete'])->middleware('auth:api');

        Route::group(['prefix' => '/{post}/likes'], function () {
            Route::post('/', [PostLikeController::class, 'store'])->middleware('auth:api');
        });
    });
});
