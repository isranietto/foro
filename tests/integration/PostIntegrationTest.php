<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostIntegrationTest extends FeatureTestCase
{
    /** @test */
    public function tesr_a_slug_is_generated_and_saved_to_the_database()
    {
        $post =  factory(\Foro\Post::class)->create([
            'title' => 'Como instalar Laravel',
        ]);

        $this->assertSame(
            'como-instalar-laravel',
            $post->fresh()->slug
        );
    }

    /** @test */
    function test_a_post_url_attribute_get_correct_direction()
    {
        $post =  factory(\Foro\Post::class)->create([
            'title' => 'Como instalar Laravel',
        ]);

        $this->visit($post->url)
                ->assertResponseOk()
                ->assertResponseStatus(200);
    }
    /** @test */
    function test_a_post_url_is_generate()
    {
        //actividad lección 14
        $user = factory(\Foro\User::class)->create();
        $post = factory(\Foro\Post::class)->create([
            'title' => 'Este es un post',
            'user_id' => $user->id
        ]);

        $this->assertSame($post->url, route('post.show', [$post->id, $post->slug]));
    }
}
