<?php

namespace Foro\Http\Controllers;

use Foro\Category;
use Foro\Post;
use Illuminate\Http\Request;

class CreatePostController extends Controller
{
    public function create()
    {
        $categories = Category::pluck('name','id')->toArray();
        return view('post.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $post = auth()->user()->createPost($request->all());

        return redirect($post->url);
    }
}
