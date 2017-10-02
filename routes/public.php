<?php


Route::get('/', ['as'=> 'post.index', 'uses' => 'PostController@index']);


Route::get('/home', 'HomeController@index');

Route::get('/post/{post}-{slug}', [
    'as'=> 'post.show',
    'uses'=> 'PostController@show'
])->where('post','\d+');

