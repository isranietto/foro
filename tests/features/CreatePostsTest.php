<?php

use Foro\Post;

class CreatePostsTest extends FeatureTestCase
{
    function test_a_user_create_a_post()
    {
        // Having
        $title = 'Esta es una Pregunta';
        $content = 'Este es el contenido';
        $this->actingAs($user = $this->defaultUser());

        $category = factory(\Foro\Category::class)->create();
        // When
        $this->visit(route('post.create'))
            ->type($title, 'title')
            ->type($content, 'content')
            ->select($category->id, 'category_id')
            ->press('Publicar');

        // Then
        $this->seeInDatabase( 'posts',[
            'title' => $title,
            'content' => $content,
            'pending' => true,
            'user_id' => $user->id,
            'slug' => 'esta-es-una-pregunta',
            'category_id' => $category->id,
        ]);

        $post = Post::first();

        $this->seeInDatabase('subscriptions' , [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $this->seePageIs($post->url);
    }

    function test_creating_a_post_requires_authentication()
    {
        $this->visit(route('post.create'))
            ->seePageIs(route('token'));
    }

    function test_create_post_form_validation()
    {
        $this->actingAs($this->defaultUser())
            ->visit(route('post.create'))
            ->press('Publicar')
            ->seePageIs(route('post.create'))
            ->seeErrors([
                'title' => 'El campo título es obligatorio',
                'content' => 'El campo contenido es obligatorio',
            ]);
    }

}