<?php

//

Route::get('/post/create', [ 'as'=> 'post.create', 'uses'=> 'CreatePostController@create' ]);
Route::post('/post/create', [ 'as'=> 'post.store', 'uses'=> 'CreatePostController@store' ]);

Route::post('/post/{post}/comment', [ 'as'=> 'comments.store', 'uses'=> 'CommentController@store' ]);
Route::post('comments/{comment}/accept',['as'=> 'comments.accept', 'uses' => 'CommentController@accept']);
Route::post('post/{post}/subscribe',['as'=> 'post.subscribe', 'uses'=> 'SubscriptionController@subscribe']);
Route::delete('post/{post}/subscribe',['as'=> 'post.unsubscribe', 'uses'=> 'SubscriptionController@unsubscribe']);