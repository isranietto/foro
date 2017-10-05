<?php


Route::get('/home', 'HomeController@index');

Route::get('/post/{post}-{slug}', [
    'as'=> 'post.show',
    'uses'=> 'ShowPostController@show'
])->where('post','\d+');

Route::get('posts-pendientes/{category?}', [
    'uses' => 'ListPostController',
    'as' => 'post.pending'
]);
Route::get('posts-completados/{category?}', [
    'uses' => 'ListPostController',
    'as' => 'post.completed'
]);

Route::get('{category?}', [
    'as'=> 'post.index',
    'uses' => 'ListPostController'
]);
