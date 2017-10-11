<?php

//
Route::post('logout', 'Auth\LoginController@logout');

Route::get('/post/create', [ 'as'=> 'post.create', 'uses'=> 'CreatePostController@create' ]);
Route::post('/post/create', [ 'as'=> 'post.store', 'uses'=> 'CreatePostController@store' ]);

Route::post('/post/{post}/comment', [ 'as'=> 'comments.store', 'uses'=> 'CommentController@store' ]);
Route::post('comments/{comment}/accept',['as'=> 'comments.accept', 'uses' => 'CommentController@accept']);
Route::post('post/{post}/subscribe',['as'=> 'post.subscribe', 'uses'=> 'SubscriptionController@subscribe']);
Route::delete('post/{post}/subscribe',['as'=> 'post.unsubscribe', 'uses'=> 'SubscriptionController@unsubscribe']);

//Vote
Route::pattern('module','[a-z]+');

Route::bind('votable', function ($votableId, $route) {
    $modules =[
        'posts' => \Foro\Post::class,
        'comments' => \Foro\Comment::class,
    ];

    abort_unless($model = $modules[$route->parameter('module')] ?? null, 404);

    return $model::findOrFail($votableId);
});

Route::post('{module}/{votable}/upvote', [
    'uses'=> 'VoteController@upvote'
]);

Route::post('{module}/{votable}/downvote', [
    'uses'=> 'VoteController@downvote'
]);

Route::delete('{module}/{votable}/vote', [
    'uses'=> 'VoteController@undoVote'
]);

Route::get('mis-post/{category?}', ['as' => 'post.mine', 'uses' => 'ListPostController']);