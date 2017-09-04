<?php


class PostListTest extends FeatureTestCase
{
    /** @test */
    function test_a_user_can_see_the_post_list_and_go_to_details()
    {
        $post = $this->createPost([
            'title' => 'Debo usar Laravel 5.3 o 5.1 Lts?'
        ]);

        $this->visit('/')
            ->seeInElement('h1', 'Post')
            ->see($post->title)
            ->click($post->title)
            ->seePageIs($post->url);
    }

    /** @test */
    function test_post_list_are_paginated()
    {
        $first = factory(\Foro\Post::class)->create([
            'title' => 'First Post',
            'created_at' => \Carbon\Carbon::now()->subDays(2)
        ]);

        factory(\Foro\Post::class)->times(15)->create([
            'created_at' => \Carbon\Carbon::now()->subDays(1)
        ]);

        $last = factory(\Foro\Post::class)->create([
            'title' => 'Last Post',
            'created_at' => \Carbon\Carbon::now()
        ]);

        $this->visit('/')
            ->see($last->title)
            ->dontSee($first->title)
            ->click('2')
            ->see($first->title)
            ->dontSee($last->title);

    }
}
