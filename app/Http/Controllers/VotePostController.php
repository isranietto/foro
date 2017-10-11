<?php

namespace Foro\Http\Controllers;

use Foro\Post;
use Foro\Vote;
use Illuminate\Http\Request;

class VotePostController extends Controller
{
    public function upvote(Post $post)
    {
        $post->upvote();

        return [
            'new_score' => $post->score
        ];
    }
    public function downvote(Post $post)
    {
        $post->downvote();

        return [
            'new_score' => $post->score
        ];
    }

    public function undoVote(Post $post)
    {
        $post->undoVote();

        return [
            'new_score' => $post->score
        ];
    }
}