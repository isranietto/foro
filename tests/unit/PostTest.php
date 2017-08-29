<?php


class PostModelTest extends FeatureTestCase
{
    /** @test */
    function test_a_title_have_a_slug()
    {
        $post =  factory('Foro\Post')->create(['title' => 'Este es un slug']);

        $this->assertEquals('este-es-un-slug', $post->slug);

    }
}
