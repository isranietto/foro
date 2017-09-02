<?php


class PostModelTest extends FeatureTestCase
{
    /** @test */
    function test_a_title_have_a_slug()
    {
        $post =  factory('Foro\Post')->create(['title' => 'Este es un slug']);

        $this->assertEquals('este-es-un-slug', $post->slug);

    }

    /** @test */
    function test_editing_the_title_change_the_slug()
    {
        $post =  new \Foro\Post([
            'title' => 'Como instalar Laravel',
        ]);

        $post->title = 'Este titulo ya cambio';

        $this->assertEquals('este-titulo-ya-cambio', $post->slug);
    }
}
