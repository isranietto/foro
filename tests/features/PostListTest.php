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
    function test_a_user_can_see_posts_posts_filtered_by_category()
    {
        $laravel = factory(\Foro\Category::class)->create([
            'name' => 'Laravel', 'slug' => 'laravel'
        ]);
        $vue = factory(\Foro\Category::class)->create([
            'name' => 'Vue.js', 'slug' => 'vue-js'
        ]);

        $laravelPost = factory(\Foro\Post::class)->create([
            'title' => 'Post de Laravel',
            'category_id' => $laravel->id
        ]);
        $vuePost = factory(\Foro\Post::class)->create([
            'title' => 'Post de Vue.js',
            'category_id' => $vue->id
        ]);

        $this->visit('/')
            ->see($laravelPost->title)
            ->see($vuePost->title)
            ->within('.categories', function () {
                $this->click('Laravel');
            })
            ->seeInElement('h1', 'Post de Laravel')
            ->see($laravelPost->title)
            ->dontSee($vuePost->title);
    }

    /** @test */
    function test_a_user_can_see_posts_posts_filtered_by_status()
    {
        $pendingPost = factory(\Foro\Post::class)->create([
            'title' => 'Post de Laravel pendiente',
            'pending' => true
        ]);
        $completePost = factory(\Foro\Post::class)->create([
            'title' => 'Post de Vue.js completo',
            'pending' => false
        ]);

        $this->visitRoute('post.pending')
            ->see($pendingPost->title)
            ->dontSee($completePost->title);

        $this->visitRoute('post.completed')
            ->see($completePost->title)
            ->dontSee($pendingPost->title);
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
