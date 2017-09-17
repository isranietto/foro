<?php

namespace Foro\Policies;

use Foro\{Comment,User};
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function accept(User $user, Comment $comment)
    {
        return $user->owns($comment->post);
    }
}
