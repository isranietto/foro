<?php

namespace Foro\Http\Controllers;

use Foro\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::all();

        return view('post.index', compact('posts'));
    }

    /**
     * @param Post $post
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show(Post $post, $slug)
    {
        if ($post->slug != $slug) {
            return redirect($post->url, 301); //301 significa
            //que es una redirección permanente por que la dirección
            //del post ha cambiado
        }
        return view('post.show',compact('post'));
    }


}
