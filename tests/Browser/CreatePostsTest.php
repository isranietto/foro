<?php

namespace Tests\Browser;

use Foro\Post;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreatePostsTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $title = 'Esta es una Pregunta';
    protected $content = 'Este es el contenido';


    function test_a_user_create_a_post()
    {
        $user = $this->defaultUser();

        $category = factory(\Foro\Category::class)->create();

        $this->browse(function ($browser) use ($user, $category){
            // Having
            $browser->loginAs($user)
                ->visitRoute('post.create')
                ->type('title',$this->title)
                ->type('content', $this->content)
                ->select('category_id', $category->id)
                ->press('Publicar')
                // Test a user is redirected to the post s details after creating it.
                ->assertPathIs('/post/1-esta-es-una-pregunta');
        });

        // Then
        $this->assertDatabaseHas( 'posts',[
            'title' => $this->title,
            'content' => $this->content,
            'pending' => true,
            'user_id' => $user->id,
            'slug' => 'esta-es-una-pregunta',
            'category_id' => $category->id,
        ]);

        $post = Post::first();

        $this->assertDatabaseHas('subscriptions' , [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }

    function test_creating_a_post_requires_authentication()
    {
        $this->browse(function ($browser) {
            $browser->visitRoute('post.create')
                ->assertRouteIs('token');
        });
    }

    function test_create_post_form_validation()
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->defaultUser())
                ->visitRoute('post.create')
                ->press('Publicar')
                ->assertRouteIs('post.create')
                ->assertSeeErrors([
                    'title' => 'El campo título es obligatorio',
                    'content' => 'El campo contenido es obligatorio',
                ]);
        });
    }
}
