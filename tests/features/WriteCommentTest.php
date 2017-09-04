<?php


class WriteCommentTest extends FeatureTestCase
{
    /** @test */
    function test_a_user_cant_write_a_comment()
    {
        $post  = $this->createPost();

        $user = $this->defaultUser();

        $this->actingAs($user)
            ->visit($post->url)
            ->type('This is a comment', 'comment')
            ->press('Publicar Comentario');

        $this->seeInDatabase('comments', [
            'comment' => 'This is a comment',
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        $this->seePageIs($post->url);
    }
    /** @test */
    function test_user_cant_not_send_empty_comment()
    {
        $post  = $this->createPost();
        $user = $this->defaultUser();

        $this->actingAs($user)
            ->visit($post->url)
            ->type('', 'comment')
            ->press('Publicar Comentario')
            ->seePageIs($post->url)
            ->see('El campo comentario es obligatorio.');
    }
}
