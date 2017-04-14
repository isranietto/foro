<?php


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/post/{post}', [
    'as'=> 'post.show',
    'uses'=> 'CreatePostController@show'
])->where('post','\d+');

