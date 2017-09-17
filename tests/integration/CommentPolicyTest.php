<?php

use Foro\Comment;
use Foro\Policies\CommentPolicy;
use Foro\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentPolicyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function test_the_post_author_can_select_a_comment_an_answer()
    {
        $comment = factory(Comment::class)->create();
        $policy = new CommentPolicy();

        $this->assertTrue(
            $policy->accept($comment->post->user,  $comment)
        );
    }

    /** @test */
    function test_not_author_cannot_select_a_comment_an_answer()
    {
        $comment = factory(Comment::class)->create();
        $policy = new CommentPolicy();

        $this->assertFalse(
            $policy->accept(factory(User::class)->create(),  $comment)
        );
    }
}
