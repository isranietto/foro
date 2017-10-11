<?php

//

Route::get('/post/create', [ 'as'=> 'post.create', 'uses'=> 'CreatePostController@create' ]);
Route::post('/post/create', [ 'as'=> 'post.store', 'uses'=> 'CreatePostController@store' ]);

Route::post('/post/{post}/comment', [ 'as'=> 'comments.store', 'uses'=> 'CommentController@store' ]);
Route::post('comments/{comment}/accept',['as'=> 'comments.accept', 'uses' => 'CommentController@accept']);
Route::post('post/{post}/subscribe',['as'=> 'post.subscribe', 'uses'=> 'SubscriptionController@subscribe']);
Route::delete('post/{post}/subscribe',['as'=> 'post.unsubscribe', 'uses'=> 'SubscriptionController@unsubscribe']);

//Vote
Route::post('/posts/{post}/upvote', [
    'uses'=> 'VotePostController@upvote'
]);

Route::post('/posts/{post}/downvote', [
    'uses'=> 'VotePostController@downvote'
]);

Route::delete('/posts/{post}/vote', [
    'uses'=> 'VotePostController@undoVote'
]);

// Comment
Route::post('/comments/{comment}/upvote', [
    'uses'=> 'VoteCommentController@upvote'
]);

Route::post('/comments/{comment}/downvote', [
    'uses'=> 'VoteCommentController@downvote'
]);

Route::delete('/comments/{comment}/vote', [
    'uses'=> 'VoteCommentController@undoVote'
]);

Route::get('mis-post/{category?}', ['as' => 'post.mine', 'uses' => 'ListPostController']);