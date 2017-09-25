<?php

namespace Foro\Http\Controllers;

use Foro\Post;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(Post $post)
    {
        auth()->user()->subscribeTo($post);

        return redirect($post->url);
    }
    public function unsubscribe(Post $post)
    {
        auth()->user()->unSubscribeFrom($post);

        return redirect($post->url);
    }
}
