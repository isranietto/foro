<?php


class AcceptAnswertTest extends FeatureTestCase
{
    /** @test */
    function test_the_post_author_can_accept_a_comment_as_the_posts_answer()
    {
        $comment = factory(\Foro\Comment::class)->create([
            'comment' => 'Esta va a ser la respuesta del post'
        ]);

        $this->actingAs($comment->post->user);

        $this->visit($comment->post->url)
            ->press('Aceptar Respuesta');

        $this->seeInDatabase('posts', [
            'id' => $comment->post->id,
            'pending' => false,
            'answer_id' => $comment->id,
        ]);

        $this->seePageIs($comment->post->url)
            ->seeInElement('.answer' , $comment->comment);
    }

    /** @test */
    function test_non_the_post_author_cannot_see_the_accept_button()
    {
        $comment = factory(\Foro\Comment::class)->create([
            'comment' => 'Esta va a ser la respuesta del post'
        ]);

        $this->actingAs(factory(\Foro\User::class)->create());

        $this->visit($comment->post->url)
            ->dontSee('Aceptar Respuesta');
    }

    /** @test */
    function test_non_the_post_author_cannot_accept_a_comment_as_the_posts_answer()
    {
        $comment = factory(\Foro\Comment::class)->create([
            'comment' => 'Esta va a ser la respuesta del post'
        ]);

        $this->actingAs(factory(\Foro\User::class)->create());

        $this->post(route('comments.accept', $comment));

        $this->seeInDatabase('posts', [
            'id' => $comment->post->id,
            'pending' => true,
        ]);
    }

    /** @test */
    function test_the_accept_button_is_hidden_when_the_comment_is_already_the_post_answer()
    {
        $comment = factory(\Foro\Comment::class)->create([
            'comment' => 'Esta va a ser la respuesta del post'
        ]);

        $this->actingAs($comment->post->user);

        $comment->markAsAnswer();

        $this->visit($comment->post->url)
            ->dontSee('Aceptar Respuesta');
    }
}
