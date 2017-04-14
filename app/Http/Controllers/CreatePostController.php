<?php

namespace Foro\Http\Controllers;

use Foro\Post;
use Illuminate\Http\Request;

class CreatePostController extends Controller
{
    public function create()
    {
        return view('post.create');
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'content' => 'required',
        ]);
        $post = new Post($request->all());
        auth()->user()->posts()->save($post);

        return $post->title;
    }

    public function show(Post $post)
    {
        return view('post.show',compact('post'));
    }
}
