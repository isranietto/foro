<?php

class CreatePostsTest extends FeatureTestCase
{
    function test_a_user_create_a_post()
    {
        // Having
        $title = 'Esta es una Pregunta';
        $content = 'Este es el contenido';
        $this->actingAs($user = $this->defaultUser());

        // When
        $this->visit(route('post.create'))
            ->type($title, 'title')
            ->type($content, 'content')
            ->press('Publicar');

        // Then
        $this->seeInDatabase( 'posts',[
            'title' => $title,
            'content' => $content,
            'pending' => true,
            'user_id' => $user->id
        ]);

        $this->see( $title);
    }

    function test_creating_a_post_requires_authentication()
    {
        $this->visit(route('post.create'))
            ->seePageIs(route('login'));
    }

}