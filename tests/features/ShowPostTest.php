<?php

class ShowPostTest extends FeatureTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_can_see_the_post_details()
    {
        // Having
        $user =  $this->defaultUser([
            'name' => 'Israel Nieto'
        ]);

        $post = factory(\Foro\Post::class)->create([
            'title' => 'Este es el titulo del post',
            'content' => 'Este es el contenido del post',
        ]);
        $user->posts()->save($post);

        // When

        $this->visit(route('post.show', $post))//post/2324
            ->seeInElement('h1', $post->title)
            ->see($post->content)
            ->see($user->name);

    }
}
